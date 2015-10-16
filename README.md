GrizzlylabMailerBundle
======================

Basic mailer service to send an e-mail with just one line of code.
It uses the mailer service delivered with Symfony 2 (Swift_Mailer).

###1. Requirements
- PHP >=5.4
- Symfony ~2.7

###2. Installation

- ```composer require 'grizzlylab/mailer-bundle@dev-master'```
- in AppKernel.php: ```new Grizzlylab\Bundle\MailerBundle\GrizzlylabMailerBundle()```

###3. Configuration

#### Configure parameters.yml
```
#app/config/parameters.yml (advice, set it in "parameters.yml.dist" also)
    #...
    mailer_sender_address: noreply@domain.com #required, will be injected in mailer service
    mailer_sender_name: GrizzlyLab #required, will be injected in mailer service
    #...
```

#### Configure SwiftMailer (if not already done)
```
#SwifMailer Configuration
swiftmailer:
    transport:      "%mailer_transport%"
    encryption:     "%mailer_encryption%"
    auth_mode:      "%mailer_auth_mode%"
    host:           "%mailer_host%"
    port:           "%mailer_port%"
    username:       "%mailer_user%"
    password:       "%mailer_password%"
    spool:          { type: memory }
    sender_address: "%mailer_sender_address%"
```
#### (OPTIONNAL) You can use your new paremeters (defined in parameters.yml) in your SwiftMailer configuration
This way, even if you send an e-mail without "grizzlylab_mailer", the "sender_address" will be the same.
```
#app/config/config.yml
#SwifMailer Configuration
swiftmailer:
    #...
    sender_address: "%mailer_sender_address%"
    #...
```

###4. Use
####1. Create a rendered template (any string) following these rules:
   * use the first line as the subject
   * use the rest as the body

####2. Finally, use the service to send an e-mail: 
```
$this->container->get('grizzlylab_mailer')->send($renderedTemplate, $sender, $toEmail);
```

That's it.

License
-------
This bundle is under the MIT license.