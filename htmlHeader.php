<?php
/*****************************************************************
* htmlHeader.php
* Updated: Saturday, Nov. 8, 2014
* 
* Joy Angeles Punongbayan
******************************************************************/

class HtmlHeader {
	private $contentHeader; //string
	private $newString;

	function __construct($header){
		$this->contentHeader = $header;
		$this->newString = '';
	}

	public function writeJSON(){
		
		foreach ($this->contentHeader->childNodes as $c) {
			
			
			if ($c->hasAttributes()) {
			  
			  $newAttributes = '';
			  
			  foreach ($c->attributes as $attr) {
				
				$newAttributes .= ($newAttributes == '' ? '"' : ',"') . $attr->nodeName . '":"'. $attr->nodeValue . '"';
				
			  }
			  
			  $this->newString .= ($this->newString == '' ? '"' : ',"') . $c->nodeName. '":{"attributes":{'. $newAttributes .'}}';
			  		
			}
			else {
				
				if ($c->nodeName == 'style') {

					$newValue = str_replace("\t", '\\t', $c->nodeValue);
					$newValue = str_replace("\r", '\\r', $newValue);
					$newValue = str_replace("\n", '\\n', $newValue);
					
					$this->newString .= ($this->newString == '' ? '"' : ',"') . $c->nodeName . '":{"attributes":{"type":"text\/css"},"value":"'. 
					$newValue .'"}';
				
				}
				else {
					$this->newString .= ($this->newString == '' ? '"' : ',"') . $c->nodeName . '":{"value":"'. $c->nodeValue .'"}';
				}
			}
			
		}	
		
		$this->newString = '"head":{"child_nodes":{'. $this->newString . '}}';
		
		return $this->newString;

	}
}
?>
