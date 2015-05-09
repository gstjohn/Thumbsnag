# Thumbsnag [![Build Status](https://travis-ci.org/gstjohn/Thumbsnag.svg?branch=master)](https://travis-ci.org/gstjohn/Thumbsnag)

Thumbsnag crawls an HTML document and finds imagery that best represents the given page.

## Example

```php
use Thumbsnag\FasterImageAnalyzer;
use Thumbsnag\Thumbsnag;
use Thumbsnag\UrlDocument;

$url = 'http://simplegifts.co';
$html = file_get_contents($url);

$document = new DOMDocument();
$document->loadHTML($html);

$analyzer = new FasterImageAnalyzer(new \FasterImage\FasterImage());

$thumbsnag = Thumbsnag::load(new UrlDocument($doc, $url), $analyzer);
$images = $thumbsnag->process();
```

After inspection, `$images` will return something like:

```bash
Array
(
  [1] => Thumbsnag\Image Object
  (
    [url:Thumbsnag\Image:private] => http://simplegifts.co/image1.jpg
    [height:Thumbsnag\Image:private] => 565
    [width:Thumbsnag\Image:private] => 849
  )

  [2] => Thumbsnag\Image Object
  (
    [url:Thumbsnag\Image:private] => http://simplegifts.co/image2.png
    [height:Thumbsnag\Image:private] => 450
    [width:Thumbsnag\Image:private] => 1162
  )
)
```

## Configuration

### Step 1: Install

Pull the package in through Composer.

```js
"require": {
  "gstjohn/thumbsnag": "~1.0"
}
```

### Step 2: Configure (as necessary)

Thumbsnag::load() takes an array as its third parameter which overrides the default config. Available configuration options are:

+ **min_area (default: 5000)**

  This option represents the minimum pixel area (width x height) required in order to be included in the result set.
  
+ **ratio_threshold (default: 3.0)**
  
  This option represents the maximum ratio of width-to-height allowed in order to be included in the result set.
  
+ **filename_filters (default: "sprite", "blank", and "spacer")**

  This option represents an array of words that must not be in the image file name in order to be included in the result set.

## Credits

+ [How to Find the Image That Best Represents a Web Page](https://tech.shareaholic.com/2012/11/02/how-to-find-the-image-that-best-respresents-a-web-page/)
+ [Crawlsane](https://github.com/michaelmcmillan/Crawlsane)

# License

Thumbsnag is open-sourced software licensed under the [MIT license](https://raw.githubusercontent.com/gstjohn/Thumbsnag/master/LICENSE).