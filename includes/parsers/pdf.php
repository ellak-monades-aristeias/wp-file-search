<?php

class PdfParser implements ParserWPfileSearch {
	public static function parse($filename) {
        if (!$filename || !file_exists($filename))
            return false;

		// Parse pdf file and build necessary objects.
		$parser = new \Smalot\PdfParser\Parser();

		$pdf = $parser->parseFile($filename);

		// Retrieve all pages from the pdf file.
		$pages = $pdf->getPages();

		// Loop over each page to extract text.
		$text = "";
		foreach ($pages as $page) {
		    $text .= $page->getText();
		}

		return $text;
	}
}
