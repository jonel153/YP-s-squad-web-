		<div class="main-content">		
			<div class="bread-nav">
			    <ul class="breadcrumb">
			    	<li><a href="">Home</a></li>
			        <li class="active">Issue Check</li>
			    </ul>
			</div>

			<div class="col-lg-12">
				 <table id="table_item_view" class="table table-hover">
			        <thead>
			            <tr>
			            	<th>Check No.</th>
			            	<th>Account No.</th>
			            	<th>Branch</th>
			            	<th>Supplier/Dealer</th>
			            	<th>Amount</th>
			            	<th>Currency</th>
			            	<th>Date</th>
			            	<th>Action</th>
			            </tr>
			        </thead>
			        <tbody>
			    
			        </tbody>
			    </table>
			</div>

			<div class="col-lg-12" id="float-btn">
				<a href="" data-toggle="modal" data-target="#modal-upload"><span class="glyphicon glyphicon-plus-sign"></span></a>
			</div>

			<div class="modal fade" id="modal-upload" tabuser="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-sm">
			    	<div class="modal-content">
			      		<div class="modal-header">
			        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			        		Add check
			      		</div>
			      		<div class="modal-body">					        
							<form method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>admin/shipment_process" id="shipment_form">
								
								<label for="userfile" >Excel file</label>
								<div class="form-group">
						    		<input id="my-file-selector" type="file" name="userfile" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
								</div>
								<div id="import_btn">
									<input type="submit" class="btn btn-info btn-sm" value="Import" id="btn-file-submit"/>
								</div>
							</form>
			      		</div>
			    	</div>
			  	</div>
			</div>
		</div>
	</div>
</div>
