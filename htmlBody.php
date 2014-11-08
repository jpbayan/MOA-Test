<?php
/*****************************************************************
* htmlBody.php
* Updated: Saturday, Nov. 8, 2014
* 
* Joy Angeles Punongbayan
******************************************************************/

class HtmlBody {
	private $contentBody; //string
	private $newString;

	function __construct($body){
		$this->contentBody = $body;
		$this->newString = '';
	}

	public function writeJSON(){
		
		foreach ($this->contentBody->childNodes as $c) {
		
			if ($c->nodeName == '#text') continue;
			
			$this->newString .= ($this->newString == '' ? '"' : ',"') . $c->nodeName;
			
		  if ($c->hasAttributes()) {
			  $newAttributes = '';
			  
			  foreach ($c->attributes as $attr) {
				
				$newAttributes .= ($newAttributes == '' ? '"' : ',"') . $attr->nodeName . '":"'. $attr->nodeValue . '"';
				
			  }
			  
			  $this->newString .= '":{"attributes":{'. $newAttributes .'}';

		  }
		  
		  if ($c->hasChildNodes()) {

			$divString = '';
			foreach ($c->childNodes as $d) {

				if ($d->nodeName == '#text') continue;
			
				  if ($d->hasAttributes()) {
					  $newAttributes = '';
					  $nodeId = '';
					  
					  foreach ($d->attributes as $dattr) {
						
						$newAttributes .= ($newAttributes == '' ? '"' : ',"') . $dattr->nodeName . '":"'. $dattr->nodeValue . '"';
						
						if($dattr->nodeName == 'id') $nodeId = '#'.$dattr->nodeValue;
						
					  }
					  
				  }	
				
				if ($d->hasChildNodes()) {
					$innerDivString = '';
					
					foreach ($d->childNodes as $innerD) {
						if ($innerD->nodeName == '#text') continue;
						
						if ($innerD->hasAttributes()) {
							$innerAttributes = '';
							
							foreach ($innerD->attributes as $innerDAttr) {
							
								if ($innerDAttr->nodeName == 'src' || $innerDAttr->nodeName == 'href')
									$newValue = str_replace("/", '\/', $innerDAttr->nodeValue);
								else 	
									$newValue = $innerDAttr->nodeValue;
						
								$innerAttributes .= ($innerAttributes == '' ? '"' : ',"') . $innerDAttr->nodeName . '":"'. $newValue . '"';
							}

							$innerDivString .= ($innerDivString == '' ? '"' : ',"') . $innerD->nodeName. '":{"attributes":{'. $innerAttributes .'}'.
							(!$innerD->nodeValue ? '' : ',"value":"'. $innerD->nodeValue . '"') .'}';
						
						}
						
						if ($innerD->hasChildNodes()) {
							$innerDivContentString = '';
							
							foreach ($innerD->childNodes as $innerDivContent) {
								if ($innerDivContent->nodeName == '#text') continue;
								
								if ($innerDivContent->hasAttributes()) {
									$innerDivAttributes = '';
									
									foreach ($innerDivContent->attributes as $innerDivAttr) {
									
										if ($innerDivAttr->nodeName == 'src' || $innerDivAttr->nodeName == 'href')
											$newValue = str_replace("/", '\/', $innerDivAttr->nodeValue);
										else 	
											$newValue = $innerDivAttr->nodeValue;
						
										$innerDivAttributes .= ($innerDivAttributes == '' ? '"' : ',"') . $innerDivAttr->nodeName . '":"'. 
										$innerDivAttr->nodeValue . '"';
									}

									$innerDivString .= ($innerDivString == '' ? '"' : ',"') . $innerDivContent->nodeName. '":{"attributes":{'. $innerDivAttributes .'}'. (!$innerDivContent->nodeValue ? '' : ',"value":"'. $innerDivContent->nodeValue . '"') .'}';
									
								}
							}
							
						}
						
					}
					
				}	
				
				$divString .= ($divString == '' ? '"' : ',"') . $d->nodeName . $nodeId . '":{"attributes":{'. $newAttributes .'}'.
				( ($innerDivString == '' ? '' : ',"child_nodes":{'. $innerDivString .'}') ) . '}';
			
			}
			
			if ($divString) {
				$this->newString .= ($this->newString == '' ? '' : ',') . '"child_nodes":{'. $divString .'}';
			}
		  }
		  
		  if (!$c->hasAttributes() && !$divString) {
			
				$this->newString .= '":{"value":"'. $c->nodeValue .'"' ;
				
			}
			
			$this->newString .= ($this->newString == '' ? '' : '}');
			
		}	
		
		$this->newString = '"body":{"child_nodes":{'. $this->newString . '}}';
		
		return $this->newString;

	}
}
?>
