# Slim Framework Plates View



This is a Slim Framework view helper built on top of the Plates templating component. You can use this component to create and render templates in your Slim Framework application.

## Install

Via [Composer](https://getcomposer.org/)

```bash
$ composer require kadevland/slim-plates-view
```

Requires Slim Framework 3 and PHP 5.5.0 or newer.

## Usage

```php
// Create Slim app
$app = new \Slim\App();

// Fetch DI Container
$container = $app->getContainer();

// Register Plates View helper
$container['view'] = function ($c) {
    $view = new \Kadevland\Slim-Plates-View\PlatesView('path/to/templates','extention');
    
    // Instantiate and add Slim specific extension 
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new \Kadevland\Slim-Plates-View\PlatesViewExtension($c['router'], $basePath));

    return $view;
};

// Define named route
$app->get('/hello/{name}', function ($request, $response, $args) {
    return $this->view->render($response, 'profile.html', [
        'name' => $args['name']
    ]);
})->setName('profile');

// Run app
$app->run();
```

## Custom template functions

This component exposes a custom `path_for()` function to your Plates templates. You can use this function to generate complete URLs to any Slim application named route. This is an example Plates template:

   
    <h1>User List</h1>
    <ul>
        <li><a href="<?php echo  path_for('profile', { 'name': 'josh' }) ?>">Josh</a></li>
    </ul>
    

## Testing

```bash
phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
