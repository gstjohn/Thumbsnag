# Thumbsnag [![Build Status](https://travis-ci.org/gstjohn/Thumbsnag.svg?branch=master)](https://travis-ci.org/gstjohn/Thumbsnag)

Thumbsnag crawls a webpage and makes a best effort at finding imagery that represents the given page.

### Example

```php
use Thumbsnag\FastImageAnalyzer;
use Thumbsnag\Thumbsnag;
use Thumbsnag\UrlDocument;

$url = 'http://simplegifts.co';
$html = file_get_contents($url);

$document = new DOMDocument();
$document->loadHTML($html);

$analyzer = new FastImageAnalyzer(new FastImage());

$thumbsnag = Thumbsnag::load(new UrlDocument($doc, $url), $analyzer);
$images = $thumbsnag->process();
```

After inspection, `$images` will return something like:

```bash
array(2) {
  [0]=>
  string(31) "http://simplegifts.co/image1.jpg"
  [1]=>
  string(31) "http://simplegifts.co/image1.jpg"
}
```

### Credits

+ [How to Find the Image That Best Represents a Web Page](https://tech.shareaholic.com/2012/11/02/how-to-find-the-image-that-best-respresents-a-web-page/)

### License

Thumbsnag is open-sourced software licensed under the [MIT license](https://raw.githubusercontent.com/gstjohn/Thumbsnag/master/LICENSE)