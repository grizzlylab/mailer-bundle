GrizzlylabMailerBundle
======================

Symfony bundle to send an e-mail with just one line of code.
It uses "symfony/twig-bundle" and "symfony/swiftmailer-bundle".

### 1. Requirements
Since 2.0, PHP 7.4+ is required and dependency "symfony/twig-bundle" replaces "symfony/templating". It means this bundle now only supports Twig.

Since 1.3, important changes have been made to [dependencies](composer.json).

Since 1.2.1, PHP 7.1+ is required.
Before this release, PHP 5.4 is the minimum required.

### 2. Installation
Run the command below to install via [composer](https://packagist.org)
```shell
composer require grizzlylab/mailer-bundle "~2.0"
```

Then enable it in your kernel:
```php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        //...
        new Grizzlylab\Bundle\MailerBundle\GrizzlylabMailerBundle()
        //...
```

### 3. Configuration

#### Configure parameters.yml
```yaml
#app/config/parameters.yml (advice, set it in "parameters.yml.dist" also)
    #...
    mailer_sender_address: noreply@domain.com #required, will be injected in mailer service
    mailer_sender_name: GrizzlyLab #required, will be injected in mailer service
    #...
```

#### Configure SwiftMailer (if not already done)
```yaml
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
#### OPTIONAL: You can use your new parameters (defined in parameters.yml) in your SwiftMailer configuration
This way, even if you send an e-mail without "grizzlylab_mailer", the "sender_address" will be the same.
```yaml
#app/config/config.yml
#SwifMailer Configuration
swiftmailer:
    #...
    sender_address: "%mailer_sender_address%"
    #...
```

### 4. Use
##### 1. Content:
###### a) By default, the $content argument is the location of a Twig template: 
```php
$container->get('grizzlylab_mailer')->send('@AcmeUser/Mail/awesome.txt.twig', $emails);
```
Rules inside your Twig template:
   * use the first line as the subject
   * use the rest as the body

###### b) If you just want to use a simple string, set the argument $contentIsATemplate to false
```php
$container->get('grizzlylab_mailer')->send('@AcmeUser/Mail/awesome.txt.twig', $emails, null, [], false);
```

##### 2. More examples
```php
//send($content, $addresses, $subject = null, array $templateParameters = [], $contentIsATemplate = true, array $sender = null)
//If the content is a template and if the subject is null, we use the first line of the template as the subject && the rest as the body

// for a single recipient, second arguement is a string (e.g. 'recipient@domain.com')
$this->container->get('grizzlylab_mailer')->send($content, $address);

// for multiple recipients, second arguement is an array
$this->container->get('grizzlylab_mailer')->send($content, $addresses);

// you can override the sender 
$sender = ['address' => adresse@domain.com, 'name' => 'GrizzlyLab'];
$this->container->get('grizzlylab_mailer')->send($content, $addresses, $sender);

// the return value is the number of recipients who were accepted for delivery
$numberOfAcceptedRecipients = $this->container->get('grizzlylab_mailer')->send($content, $addresses, $sender);
```

That's it!

License
-------
This bundle is under the MIT license.
