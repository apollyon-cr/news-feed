<?PHP
	class Panel {
		
		private $width = 0;
		private $height = 0;
		private $type = "";
		private $class_name = "";
		private $content;
		private $left;
		private $top;
		
		function __construct($t, $c) {
			 $this->type = $t;
			 $this->content = $c;
			 
			 switch($t){
				case "large long":
					$this->width = 630;
					$this->height = 310;
					$this->class_name ="lrg_ln";
					break;
				case "large short":
					$this->width = 470;
					$this->height = 310;
					$this->class_name ="lrg_sh";
					break;
				case "medium rectangle":
					$this->width = 310;
					$this->height = 150;
					$this->class_name ="med_rec";
					break;
				case "medium square":
					$this->width = 310;
					$this->height = 310;
					$this->class_name ="med_sq";
					break;
				case "small":
					$this->width = 150;
					$this->height = 150;
					$this->class_name ="small";;
					break;					
				default:
					echo "not a valid type";
			 }
		}
		
		function calcArea() {
			$area = $this->width * $this->height; 
			return $area;
		}
		
		function getWidth() {
			return $this->width;
		}
		
		function getHeight() {
			return $this->height;
		}
		
		function getType() {
			return $this->type;
		}
		
		function getLeft() {
			return $this->left;
		}
		
		function getTop() {
			return $this->top;
		}
		
		function display($l, $t) {
			$this->left = $l;
			$this->top = $t;
			?>
			<div class="<?PHP echo $this->class_name;?>" style="left: <?PHP echo $l ?>px; top: <?PHP echo $t ?>px;" ><?PHP echo $this->content;?></div>
			<?PHP			
		}

	}
	
	class RandomPanelCreator {
		const CONTAINER_WIDTH = 960;
		const CONTAINER_HEIGHT = 480;
		private $init_array = array();
		private $out_array = array();
		
		function __construct() {
			$ll = new Panel("large long", "");
			$ls = new Panel("large short", "");
			$ms = new Panel("medium square", "");
			$mr = new Panel("medium rectangle", "");
			$s = new Panel("small", "");
		
			$this->init_array = array(
				$ll, $ls, $ms, $mr, $s);
			
			$width_full = false;
			$height_full = false;
			$oa_index = 0;
			
			$total_of_panels_TOP = 0;
			$space_remaining_TOP = 0;
			
			$total_of_panels_BOTTOM = 0;
			
			$random_int = rand (0, 4);
			$this->out_array[0] = $this->init_array[$random_int];
			$total_of_panels_TOP += $this->out_array[0]->getWidth() + 10;
			$oa_index += 1;
			$this->out_array[0]->display(0, 0);
			
			while (!$width_full) {
				$space_remaining_TOP = self::CONTAINER_WIDTH - $total_of_panels_TOP;
				$random_int = rand (0, 4);
				$this->out_array[$oa_index] = $this->init_array[$random_int];
				if(($space_remaining_TOP - $this->out_array[$oa_index]->getWidth() + 10) > 150) {
					$total_of_panels_TOP += $this->out_array[$oa_index]->getWidth() + 10;
					
					$this->out_array[$oa_index]->display(($total_of_panels_TOP - $this->out_array[$oa_index]->getWidth() - 10), 0);
					$oa_index += 1;
				}
				else {
					while(!$width_full){
						$space_remaining_TOP = self::CONTAINER_WIDTH - $total_of_panels_TOP;
						if ($space_remaining_TOP > 150){
							$this->out_array[$oa_index] = $this->init_array[4];
							$total_of_panels_TOP += $this->out_array[$oa_index]->getWidth() +10;
							
							$this->out_array[$oa_index]->display(($total_of_panels_TOP - $this->out_array[$oa_index]->getWidth() - 10), 0);
							$oa_index += 1;
						}
						else $width_full = true;
						
					}
					
				}
			}
			//if the last 1 panel of out array is 'small' insert small
			//if the last 2 panels of out array are 'small' insert med-sq
			//if the last 3 panels of out array are 'small' insert lrg-sh
			//if the last 4 or more panels of out array are 'small' insert large long 
			
			$num_sml_panels = 1;
			$i = count($this->out_array)-2; //offest because last panel is always 'small'
			
			while ($i != 0){	
				if ($this->out_array[$i]->getType() == "small"){
					$num_sml_panels += 1;
					$i -= 1;
				}
				else break; 
			}
	
			switch ($num_sml_panels) {
				case 1:
					$this->out_array[$oa_index+1] = $this->init_array[4];
					$this->out_array[$oa_index+1]->display(800, 160);
					$oa_index += 1;
					break;
				case 2:
					$this->out_array[$oa_index+1] = $this->init_array[2];
					$this->out_array[$oa_index+1]->display(640, 160);
					$oa_index += 1;
					break;
				case 3:
					$this->out_array[$oa_index+1] = $this->init_array[1];
					$this->out_array[$oa_index+1]->display(480, 160);
					$oa_index += 1;
					break;				
				case 4: //falls through
				case 5:
					$this->out_array[$oa_index+1] = $this->init_array[0];
					$this->out_array[$oa_index+1]->display(320, 160);
					$oa_index += 1;
					break;
				
				default:
					break;
			
			}
			
			//move from left to right check available area and insert appropriate panel and check area available
			
			$total_short_panel = 0;
			$i = 0;
			
			while (($this->out_array[$i]->getType() == "small") || ($this->out_array[$i]->getType() == "medium rectangle")) {
				if ($i == count($this->out_array) - 2) break;
				else if ($this->out_array[$i]->getType() == "small") {
					$total_short_panel += 1;
					$i++;
					
				}
				else {
					$total_short_panel += 10;
					$i++;
				}
			}
			
			echo $total_short_panel;
			
			
			
			if ($total_short_panel < 2 && $total_short_panel > 0) {
					$this->out_array[$oa_index+1] = $this->init_array[4];
					$this->out_array[$oa_index+1]->display(0, 160);
					$oa_index += 1;
			}
			else if ($total_short_panel > 2 && $total_short_panel < 10){
					$this->out_array[$oa_index+1] = $this->init_array[2];
					$this->out_array[$oa_index+1]->display(0, 160);
					$oa_index += 1;
			}
			else if ($total_short_panel == 10){
					$this->out_array[$oa_index+1] = $this->init_array[2];
					$this->out_array[$oa_index+1]->display(0, 160);
					$oa_index += 1;
			
			}
			else if ($total_short_panel > 10 && $total_short_panel < 12) {
					$this->out_array[$oa_index+1] = $this->init_array[1];
					$this->out_array[$oa_index+1]->display(0, 160);
					$oa_index += 1;
			
			}
			else if ($total_short_panel == 13) {
					$this->out_array[$oa_index+1] = $this->init_array[1];
					$this->out_array[$oa_index+1]->display(0, 160);
					$oa_index += 1;				
			
			}
			
			else if ($total_short_panel > 13) {
					$this->out_array[$oa_index+1] = $this->init_array[1];
					$this->out_array[$oa_index+1]->display(0, 160);
					$oa_index += 1;
			
			}
			
			
			
			function currentAreaAvail() {
				$total_area = 0;
				for ($i; $i<count($this->out_array)-1; $i++){
					$total_area += $this->out_array[$i]->getArea();
				}
				return (960*480) - $total_area;
			}
			
			
			
			//echo $num_sml_panels;
			echo $oa_index; // same number as panels
			//echo $total_of_panels_TOP;
		}
	}


	
	
?>

<html>
<head>
<link rel="stylesheet" href="news.css" media="screen"/> 
</head>

<body>

<div id="container">
	<?PHP
		$rpc = new RandomPanelCreator();
		
	?>

</div>

</body>
