# AmountToWords
Converts float type PLN amount into words

Konwertuje kwotę w formacie liczbowym na kwotę słownie w polskich złotych


#Installation

```php
composer require hajs86/amount-to-words
```

#Usage

```php

$converter = new AmountToWords();

echo $converter->convert(156.20); // will print "Sto pięćdziesiąt sześć złotych dwadzieścia groszy"

```