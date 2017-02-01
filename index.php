<!DOCTYPE HTML>
<html>
	<head>
		<title>Invoice Maker</title>
 
		<link href="css/bootstrap.css" rel="stylesheet" type="text/css"    />
	 
		
		<script src="js/jquery.min.js"></script>
  
  <style>
  .hide
  {
	  visibility:hidden;
	  
  }
  
  pre,img
  {
	  
	  border:0px;
  }
  
  </style>
  
  
	</head>
	<body style="background-color:whitesmoke;">
<?php

$currency = "$";

?>	 
	 
	 <button onclick="start_print()" class="btn btn-default hidden-print" >Print</button>
	 

  <div id="invoice" class="container" style="background-color:white;">
  <div class="row">
  
  <div class="col-xs-12">
  <h3 class="text-primary"> Invoice </h3>
  <hr/>
  </div>
  
  <div class="col-xs-6">
  <p></p>
  <pre contenteditable>
[CompanyName]
[AddressLine1]
[AddressLine2]
[City], [State] [ZipCode] 
[PhoneOffice] [PhoneFax]
[EmailAddress] [Website]


</pre>
  
  </div>
  
  <div class="col-xs-6">
    <p></p>
    <div class=" ">
			  <p class="text-muted hidden-print">Company Logo</p>
    <img src="" id="pre1"   class="img-responsive "  title="" style="cursor:pointer; width:200px; height:100px;"/>
     </div>
     
	 
	
 	 <input type="file" id="file1" onchange="uploadAsBase64(this,1);   "  class="hidden-print" />		  <br/> 

	 <input type="text"  id="bs1" class="hide"   />

										  
	 <div class="col-md-12 text-center">
	 <progress id="progressBar1" value="0" max="100" style="width:100px; visibility:hidden"></progress>
	 <h6 id="status1" class="hide"></h6>
	 <p id="loaded_n_total1" class="hide"></p>
	 </div>  
  
			  
  
  </div>
  
  
  <div class="col-xs-6">
  <pre contenteditable>
To:
[Customer Name]
[Customer Address Line 1]
[Customer Address Line 2]
[Customer City, State ZIP Code]


  </pre>
  
  </div>
  
  <div class="col-xs-6">
    <pre contenteditable>
Invoice No.: [Type number here]
Ship to (if different address):
[Customer Name]
[Customer Address Line 1]
[Customer Address Line 2]
[Customer City, State ZIP Code]




  </pre>
  
  </div>
  
  
     <table id="invoice_table" class="table table-bordered"  border="1"  style="width:100%; border-color:black;">
	 
	 <tr style="background-color: rgb(189,202,211); color:rgb(0,80,158);">
	 
	 	 <th>
	 Description
	 </th>
	 
	 
	 <th>
	 Quantity
	 </th>
	 
 
	 
	 <th>
	 Unit Price 
	 </th>
	 
	 <th>
	 Amount
	 </th>
	 
	 
	 </tr> 
	 
	 
	 <tr>
	 
	  <th class="description" contenteditable>
 
		</th>
	
	
	 
	 <th class="quantity"  onkeydown="processor()" onkeyup="processor()" contenteditable>
	  
	 </th>
	 
	 
	 
	 <th class="unit_price" onkeydown="processor()" onkeyup="processor()" contenteditable>
 
	</th>
	 
	 <th class="amount"  >
	  0.00
	 </th>
	 
	 <th class="control wdt hidden-print" >
	 
	 <button onclick="addRow()" class="hidden-print"> ADD ROW </button>
	 </th>
	 
	 </tr>
	 
	 
	 
	 
	 
	 </table>
	 
	 
 
	  
	<div id="invoice_total"    >
	
	 <table id="xtras" align="right">
 	
	<tr align="center">
	<td>
	<strong>Sub Total &nbsp;  </strong> 
	</td>
	
	<td>
	<?php echo $currency; ?><span id="sub_total">  0.00</span>   
	</td>
	
	<td class="wdt">
	<button onclick="addExtras()" class="hidden-print">+</button>
	</td>
	
	 
	 </tr>
	 
	 
	 </table>
	 
	  
 

	</div>
	
	
	
	 
	
	 </div>
	</div>
	 
	
	  <div   style="width:50%; margin-left:25%; margin-right:25%; height:auto;   padding:40px;">
	 <table align="right">
 	
	<tr align="left">
	<td>
	<strong>Total Due &nbsp; &nbsp;</strong> 
	</td>
	
	<td>
<?php echo $currency; ?>	<span id="total_due"> 0.00</span>   
	</td>
	
	 
	 
	 </tr>
	 
	 
	 </table>
	 
	 </div>
	 
	 
	 
	 <script>
	 
	 function addRow()
	 {
		 
		 var invoice_table  = document.getElementById("invoice_table");
		 
		 var rowTemp = 	' <tr>'+
						' <th class="description" contenteditable>'+
						'</th>'+
						
						 '<th class="quantity" onkeydown="processor()" onkeyup="processor()" contenteditable>'+
						  
						' </th>'+
						 
						' <th class="unit_price" onkeydown="processor()" onkeyup="processor()" contenteditable>'+
					 
						 '</th>'+
						 
						' <th class="amount"  >'+
						 ' 0.00'+
						 '</th>'+
						 
						 '<th class="control hidden-print">'+
						 
 						' <button class="wdt hidden-print" onclick="deleteRow(this)"> x </button>'+
						' </th>'+
						 
						' </tr>';
						
						
		invoice_table.innerHTML+=rowTemp;
		
		processor();
		 
	 }
	 
	 
	 function delxt(dis)
	 {
		 
		 if(confirm("Are you sure you want to delete this row?"))
		 {
		 $($(dis).closest("tr")).remove(); 
		 }
		 processor();
		 
	 }
	 
	 function deleteRow(dis)
	 {
		 
		 if(confirm("Are you sure you want to delete this row?"))
		 {
		 $($(dis).closest("tr")).remove(); 
		 }
		 processor();
		 
	 }
	 
	 
	 function processor()
	 {
		 var stotal=0;
		 
		 var sub_total = document.getElementById("sub_total");
		 
		  var quantity = document.getElementsByClassName("quantity");
		  var unit_price = document.getElementsByClassName("unit_price");
		  var amount = document.getElementsByClassName("amount");
		  var total_due = document.getElementById("total_due");
		  
		  var xt = document.getElementsByClassName("xt");  //Extra such as tax, vat....
		  
		  
		  for(i=0; i<quantity.length; i++)
		  {
			  
			    if(  !isNaN(parseInt(quantity[i].innerHTML) * parseInt(unit_price[i].innerHTML)))
				{
			   amount[i].innerHTML = parseInt(quantity[i].innerHTML) * parseInt(unit_price[i].innerHTML);
				}
				else
				{
					
					amount[i].innerHTML ="0.00";
				}
			  
		  }
		  
		  for(j=0; j<amount.length; j++)
		  {
			  
			   
			    stotal+=  parseInt(amount[j].innerHTML);
			
			  
		  }
		  
		  sub_total.innerHTML=stotal;
		 
		 
		  var st = stotal;
		  
		  
		  for(k=0; k<xt.length;k++)
		  {
			  
			    
			st+=parseInt(xt[k].innerHTML);
			  
		  }
		  
		  total_due.innerHTML = st;
		  
		  
	 }
	 
	 
 function addExtras()
 {
	 
	 
	 var xtras = document.getElementById("xtras");
	 
	 var temp = 	'<tr align="center">'+
					'<td   contenteditable>'+
					'<strong>Title here</strong> '+
					'</td>'+
					
					'<td  > <?php echo $currency; ?>'+
					'<span class="xt" contenteditable  onkeydown="processor()" onkeyup="processor()" >0.00</span> <button class="wdt hidden-print"  onclick="delxt(this)">x</button> '+
					'</td>'+
					 
					' </tr>';
	 
	 
	 xtras.innerHTML+=temp;
 }
 
 function start_print()
 {
	 
	  window.print();
	      
 }
 
 
 
 //gile uploadings
 
 function trigger(x)
												 {
													 
													 var f = document.getElementById("file"+x+"");
													     f.click();
												 }
												 
												 
												 function uploadAsBase64(file,x) {

 
														var input = file;
													 
														
														if (input.files && input.files[0]) {
															var reader = new FileReader();

															reader.onload = function (e) 
															{
															 	 var pre = document.getElementById("pre"+x+"");
																 
															 	 var bs = document.getElementById("bs"+x+"");

																	pre.src=e.target.result;
																	
																	bs.value = e.target.result;
																	  uploader(x);
															}

															reader.readAsDataURL(input.files[0]);
														}
														
														 
													}

														function uploader(n)

														{
															
															 //  alert("running uploader");
															
																var fileInputElement  = document.getElementById("file"+n+"");
																
																
																  if (window.XMLHttpRequest) {
														// code for IE7+, Firefox, Chrome, Opera, Safari
														xmlhttp = new XMLHttpRequest();
													} else {
														// code for IE6, IE5
														xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
													}
													xmlhttp.onreadystatechange = function() {
														
														 
								 
													  if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
													 
														           
														  // alert(xmlhttp.responseText);
																   
																   
																	}
														 
								
															}
							
 							
 
														var formData = new FormData(); 
														formData.append("status",status);  
														formData.append("program_image", fileInputElement.files[0]);
					 
						                                         
																xmlhttp.upload.addEventListener("progress", function(){ progressHandler(event,n); }, false);
																xmlhttp.addEventListener("load",function(){  completeHandler(event,n); }, false);
																xmlhttp.addEventListener("error",function(){  errorHandler(event,n); }, false);
																xmlhttp.addEventListener("abort", function(){ abortHandler(event,n); }, false);
																xmlhttp.open("POST", "uploaderr.php");
																xmlhttp.send(formData);
																
																
														}
											 
											 
								
 											   
														 
														 
														
														
														
														function _(el){
									return document.getElementById(el);
																}
																
																
														function progressHandler(event,n){
															
															_("progressBar"+n).style.visibility="visible";
															
											_("loaded_n_total"+n).innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
											var percent = (event.loaded / event.total) * 100;
											_("progressBar"+n).value = Math.round(percent);
											_("status"+n).innerHTML = Math.round(percent)+"% uploaded... please wait";
																					}
																					
																					
																function completeHandler(event,n){
																	
																	var resp = event.target.responseText.split("<[]>");
																	
																	_("status"+n).innerHTML=resp[0];
																	_("pre"+n).src=resp[1];
																 
																	
																	
																	_("bs"+n).value=resp[1];
																		
																	_("progressBar"+n).style.visibility="hidden";
																	_("progressBar"+n).value = 0;
																}
																
																 
																
																
															 
																
																function errorHandler(event,n){
																	_("status"+n).innerHTML = "Upload Failed";
																}
																function abortHandler(event,n){
																	_("status"+n).innerHTML = "Upload Aborted";
																}
	 
	 </script>
	 

	 
	</body>
</html>

