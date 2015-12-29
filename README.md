# StringTemplate for PHPTransformers

[StringTemplate](https://github.com/nicmart/StringTemplate) support for [PHPTransformers](http://github.com/phptransformers/phptransformer).

## Install

Via Composer

``` bash
$ composer require phptransformers/string-template
```

## Usage

``` php
$engine = new StringTemplateTransformer(array('left_delimiter' => ':', 'right_delimiter' => '');
echo $engine->render('Hello, :name!', array('name' => 'phptransformers');
```

## Testing

``` bash
$ phpunit
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.