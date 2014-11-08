<?php
/*****************************************************************
* HTML2JSON.php
* Updated: Saturday, Nov. 8, 2014
* 
* Joy Angeles Punongbayan
*
* Creates a JSON file at the given URL
******************************************************************/

ini_set('display_errors', 'On');
ini_set('memory_limit', '-1');
include_once "htmlHeader.php";
include_once "htmlBody.php";

class HTML2JSON {

	public function contentToJSON($url) {

		$c = curl_init($url);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		$html = curl_exec($c);
		if (curl_error($c))
			die(curl_error($c));

		// Check return status
		$status = curl_getinfo($c, CURLINFO_HTTP_CODE);
		curl_close($c);
		
		if (!(200 <= $status && 300 > $status))
			die('Failed to get html from '.$url.'<br />');

		# Create a DOM parser object
		$dom = new DOMDocument();

		$dom->loadHTML($html);
		
		$main = $dom->getElementsByTagName('html')->item(0);
		
		$htmlAttributes = "";
		
		if ($main->hasAttributes()) {
		  foreach ($main->attributes as $attr) {
			$name = $attr->nodeName;
			$value = $attr->nodeValue;
			
			$htmlAttributes .= ($htmlAttributes == '' ? '"' : ',"') . $name. '":"'. $value . '"';
			
		  }
		}	
			
		$htmlAttributes = '"attributes":{'.$htmlAttributes.'},"value":""';
		
		
		//echo $htmlAttributes;	
		$childContent = '';
		
		if ($main->hasChildNodes()) {
			foreach ($main->childNodes as $p) {
			  if ($p->hasChildNodes()) {
				  if ($p->nodeName == 'head') {
					$headerObject = new HtmlHeader($p);
					$childContent .= ($childContent == '' ? '' : ',') . $headerObject->writeJSON();	
				  }
				  
				  if ($p->nodeName == 'body') {
					$headerBody = new HtmlBody($p);
					$childContent .= ($childContent == '' ? '' : ',') . $headerBody->writeJSON();	
				  }
				  
			  } else {
					
			  }	
				
			  
			
			}	

		}
		
		
		$output = '{"html":{'. $htmlAttributes . ', "child_nodes":{'. $childContent .'}'. '}}';
	
		$outfile = 'films.json';
		if (false == ($out_handle = fopen($outfile, 'w')))
			die('Failed to create output file.');
			
		fwrite($out_handle, $output);
		fclose($out_handle);

	
	}
}



			
?>
