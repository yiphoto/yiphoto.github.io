# Copyright 2001-2004 Six Apart. This code cannot be redistributed without
# permission from www.movabletype.org.
#
# $Id: NotifyList.pm,v 1.6 2004/06/15 20:19:02 ezra Exp $

package MT::App::NotifyList;

use MT::App;

use base 'MT::App';

sub init {
    $app = shift;
    $app->SUPER::init(@_) or return;
    $app->add_methods('subscribe' => \&subscribe,
		      'confirm' => \&confirm,
		      'unsubscribe' => \&unsubscribe);
    $app->{default_mode} = 'subscribe';
}

sub subscribe {
    $app = shift;
    my $q = $app->{query};
    unless ($q->param('blog_id') && $q->param('email') && $q->param('_redirect'))
    {
	die "Missing required parameter, blog_id, email, or _redirect.";
    }
    my $blog = MT::Blog->load($q->param('blog_id'))
        || die "No blog found with the given blog_id.";
    my $subscr_addr = $q->param('email');
    my $secret = $app->{cfg}->EmailVerificationSecret
	|| die "Email notifications have not been configured! The weblog owner needs to set the EmailVerificationSecret configuration variable.";
    my $admin_email_addr = $app->{cfg}->EmailAddressMain 
	|| die "You need to set the EmailAddressMain configuration value "
	. "to your own email address in order to use notifications";
    die "The address you entered does not look like a real email address."
	unless MT::Util::is_valid_email($subscr_addr);


    my @pool = ('A'..'Z','a'..'z','0'..'9');
    my $salt = join '', (map {$pool[rand @pool]} 1..2);
    my $magic = crypt($secret.$subscr_addr, $salt);
    $body = MT->build_email('verify-subscribe.tmpl',
			    {script_path => $app->{cfg}->CGIPath
				 . '/mt-add-notify.cgi',
			     blog_id => $blog->id,
			     blog_name => $blog->name,
			     _redirect => $q->param('_redirect'),
			     magic => $magic,
			     email => $subscr_addr}); 
    use MT::Mail;
    MT::Mail->send({From => $admin_email_addr,
		    To => $subscr_addr,
		    Subject => "Please verify your email to subscribe"}, $body);
    <<HTML;
An email has been sent to $subscr_addr. To complete your subscription, 
please follow the link contained in that email. This will verify that
the address you provided is correct and belongs to you.
HTML
}

sub confirm {
    $app = shift;
    my $q = $app->{query};

    # email confirmed

    unless ($q->param('blog_id') && $q->param('email') &&
	    $q->param('_redirect')) {
	print $q->header;
	print "Missing required parameters\n";
	exit;
    }

    require MT::Notification;
    my $note = MT::Notification->new;
    $note->blog_id( $q->param('blog_id') );
    $note->email( $q->param('email') );
    $note->save;

    print $q->redirect($q->param('_redirect'));
}

sub unsubscribe {
    my $app = shift;

    my $q = $app->{query};

    # TBD: Do we need to confirm the email in this case?
    #      I say no.
    my $email = $q->param('email');
    require MT::Notification;
    my $notification = MT::Notification->load({email => $email});
    return "The address $email was not subscribed.\n\n" if !$notification;
    $notification->remove();
    return "The address $email has been unsubscribed.\n\n";
}

1;
