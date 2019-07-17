<link href="<?php echo SELLER_THEME_URL; ?>css/cryptofont.min.css" rel="stylesheet">
<?php 
  $shipping_address = json_decode($order_info->shipping_address);
?>
<div style="margin:0;padding:0 15px;font-family:'Poppins',sans-serif;font-size:14px;background:white">
   <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:100%;max-width:600px;background:white;border-radius:10px">
      <tbody>
         <tr>
            <td>
               <h2 style="font-size:14px;color:#000000;font-weight:400;text-align:left;font-family:'Poppins',sans-serif;margin:0;padding-bottom:15px">
                  <b>Hey 
                    <?php 
                      if($shipping_address->first_name) 
                        echo ucwords($shipping_address->first_name).','; 
                      else 
                        echo ",";
                    ?>  
                  </b>
               </h2>
            </td>
         </tr>
         <tr>
            <td>
               <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:100%;max-width:600px;background:white">
                  <tbody>
                     <tr>
                        <td valign="top" style="width:60%">
                           <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:100%;max-width:600px;background:white">
                              <tbody>
                                 <tr>
                                    <td style="width:40%;font-size:14px;color:#000000;font-weight:500;text-align:left;font-family:'Poppins',sans-serif;padding-bottom:10px">
                                       Order number
                                    </td>
                                    <td style="font-size:14px;color:#000000;font-weight:400;text-align:left;font-family:'Poppins',sans-serif;padding-bottom:10px">
                                       <?php if($order_info->order_id) echo $order_info->order_id; else echo "-"; ?>                              
                                    </td>
                                 </tr>
                                 <tr>
                                    <td style="width:40%;font-size:14px;color:#000000;font-weight:500;text-align:left;font-family:'Poppins',sans-serif;padding-bottom:10px">
                                       Placed on
                                    </td>
                                    <td style="font-size:14px;color:#000000;font-weight:400;text-align:left;font-family:'Poppins',sans-serif;padding-bottom:10px">
                                       <?php if($order_info->order_id) echo date('d M Y',strtotime($order_info->created)); else echo "-"; ?><?php  ?>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td style="width:40%;font-size:14px;color:#000000;font-weight:500;text-align:left;font-family:'Poppins',sans-serif;padding-bottom:10px">
                                       Payment Method
                                    </td>
                                    <td style="font-size:14px;color:#000000;font-weight:400;text-align:left;font-family:'Poppins',sans-serif;padding-bottom:10px">
                                       <?php if($order_info->order_id) echo ucwords(getCurrency($order_info->currency_type)); else echo "-"; ?>
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td valign="top" style="width:40%">
                           <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:100%;max-width:600px;background:white">
                              <tbody>
                                 <tr>
                                    <td style="font-size:14px;color:#000000;font-weight:500;text-align:left;font-family:'Poppins',sans-serif;padding-bottom:10px">
                                       Sub Total
                                    </td>
                                    <td style="font-size:14px;color:#000000;font-weight:400;text-align:right;font-family:'Poppins',sans-serif;padding-bottom:10px">
                                       <?php
                                           $price = array_sum(array_column($orders_details,'price'));
                                           if($price){
                                             if($order_info->currency_type==1){
                                               $priceGross = $price * $order_info->currency_amount_in_ethereum;
                                             }else if($order_info->currency_type==2){
                                               $priceGross = $price * $order_info->currency_amount_in_bitcoin;
                                             }else{
                                               $priceGross = $price * $order_info->currency_amount_in_dollor;
                                             }
                                             echo getCurrencyIcon($order_info->currency_type).''.number_format($priceGross, 8); 
                                           }else{
                                             echo "0.00";
                                           }  
                                       ?>                             
                                    </td>
                                 </tr>
                                 <tr>
                                    <td style="font-size:14px;color:#000000;font-weight:500;text-align:left;font-family:'Poppins',sans-serif;padding-bottom:10px">
                                       Shipping Charge
                                    </td>
                                    <td style="font-size:14px;color:#000000;font-weight:400;text-align:right;font-family:'Poppins',sans-serif;padding-bottom:10px">
                                       <?php
                                           $shipping_charges = array_sum(array_column($orders_details,'shipping_charges'));
                                           if(!empty($shipping_charges) && $shipping_charges > 0.00){
                                             if($order_info->currency_type==1){
                                               $shipping_chargesGross = $shipping_charges * $order_info->currency_amount_in_ethereum;
                                             }else if($order_info->currency_type==2){
                                               $shipping_chargesGross = $shipping_charges * $order_info->currency_amount_in_bitcoin;
                                             }else{
                                               $shipping_chargesGross = $shipping_charges * $order_info->currency_amount_in_dollor;
                                             }
                                             echo getCurrencyIcon($order_info->currency_type).''.number_format($shipping_chargesGross, 8); 
                                           }else{
                                             echo "-";
                                           }  
                                       ?>                            
                                    </td>
                                 </tr>
                                 <tr>
                                    <td style="font-size:14px;color:#000000;font-weight:500;text-align:left;font-family:'Poppins',sans-serif;padding-bottom:10px">
                                       Total
                                    </td>
                                    <td style="font-size:14px;color:#000000;font-weight:500;text-align:right;font-family:'Poppins',sans-serif;padding-bottom:10px">
                                       <?php
                                           $subtotal = array_sum(array_column($orders_details,'subtotal'));
                                           if(!empty($subtotal) && $subtotal > 0.00){
                                             if($order_info->currency_type==1){
                                               $subtotalGross = $subtotal * $order_info->currency_amount_in_ethereum;
                                             }else if($order_info->currency_type==2){
                                               $subtotalGross = $subtotal * $order_info->currency_amount_in_bitcoin;
                                             }else{
                                               $subtotalGross = $subtotal * $order_info->currency_amount_in_dollor;
                                             }
                                             echo getCurrencyIcon($order_info->currency_type).''.number_format($subtotalGross, 8); 
                                           }else{
                                             echo "-";
                                           }  
                                       ?>                                
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                     </tr>
                  </tbody>
               </table>
            </td>
         </tr>
         <tr>
            <td>
               <p style="font-size:14px;color:#000000;font-weight:500;text-align:left;font-family:'Poppins',sans-serif;margin:0;padding-top:15px;padding-bottom:15px">
                  <b>Order Items</b>
               </p>
            </td>
         </tr>
         <tr>
            <td>
               <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:100%;max-width:600px;background:white">
                  <tbody>
                     <?php
                        $i=0;
                        $product_price = 0.00;
                        $shipping_charges = 0.00;
                        $total = 0.00; 

                        foreach ($orders_details as $row) {
                          $i++; 
                          $product_details = json_decode($row->product_details);
                          $Image = $product_details->image;
                          $Image = explode(',', $Image);
                     ?>
                     <tr>
                        <td><img width="80px" height="auto" src="<?php echo base_url(); ?>assets/uploads/seller/products/small_thumbnail/<?php echo $Image[0]; ?>" class="CToWUd"></td>
                        <td>
                           <p style="font-size:14px;color:#000000;font-weight:400;text-align:left;font-family:'Poppins',sans-serif;margin:0;padding-bottom:10px">
                              <?php echo $product_details->title; ?><br>
                              <span style="font-size:12px"><b>QUANTITY:</b> 1</span>
                              <?php 
                                $product_variation_info = $product_details->product_variation_info;
                                if(!empty($product_variation_info) && $product_variation_info!=''){
                                  echo "<br>";
                                  $tempMore = "";
                                  $product_variation_info = json_decode($product_variation_info);
                                  if(!empty($product_variation_info)){
                                    foreach ($product_variation_info as $key => $value) {
                                      $tempMore .= "<span style='font-size:12px'><b>".ucfirst($key)." :</b> &nbsp;".ucfirst($value)."</span><br>";
                                    }
                                  }
                                }else{
                                  echo "<br>";
                                  $tempMore = "";
                                  $product_basic_info = json_decode($product_details->product_basic_info);
                                  if(!empty($product_basic_info)){
                                    foreach ($product_basic_info as $key => $value) {
                                      $tempMore .= "<span style='font-size:12px'><b>".ucfirst($key)." :</b> &nbsp;".ucfirst($value)."</span><br>";
                                    }
                                  }
                                }
                                echo $tempMore;
                              ?>
                           </p>
                           <p style="font-size:14px;color:#000000;font-weight:500;text-align:left;font-family:'Poppins',sans-serif;margin:0;padding-bottom:15px">
                              <?php
                                 if(!empty($row->subtotal) && $row->subtotal > 0.00){
                                   if($order_info->currency_type==1){
                                     $subtotalGross = $row->subtotal * $order_info->currency_amount_in_ethereum;
                                   }else if($order_info->currency_type==2){
                                     $subtotalGross = $row->subtotal * $order_info->currency_amount_in_bitcoin;
                                   }else{
                                     $subtotalGross = $row->subtotal * $order_info->currency_amount_in_dollor;
                                   }
                                   echo getCurrencyIcon($order_info->currency_type).''.number_format($subtotalGross, 8); 
                                 }else{
                                   echo "-";
                                 }  
                              ?>                           
                           </p>
                        </td>
                     </tr>
                     <tr>
                        <td colspan="2">&nbsp;</td>
                     </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </td>
         </tr>
         <?php 
            if(isset($shipping_address) && !empty($shipping_address)){ 
              $country = getData('countries',array('id',$shipping_address->country))->name;
              $state = getData('states',array('id',$shipping_address->state))->name;
              $city = getData('cities',array('id',$shipping_address->city))->name;
         ?>
         <tr>
            <td>
               <p style="font-size:14px;color:#000000;font-weight:500;text-align:left;font-family:'Poppins',sans-serif;margin:0;padding-top:15px;padding-bottom:15px">
                  <b>Delivery Address</b>
               </p>
            </td>
         </tr>
         <tr>
            <td>
               <p style="font-size:14px;color:#000000;font-weight:500;text-align:left;font-family:'Poppins',sans-serif;margin:0;padding-bottom:10px">
                  <?php 
                    if($shipping_address->first_name) 
                      echo ucwords($shipping_address->first_name.' '.$shipping_address->last_name); 
                    else 
                      echo "-";
                  ?>        
               </p>
               <p style="font-size:14px;color:#000000;font-weight:400;text-align:left;font-family:'Poppins',sans-serif;margin:0;padding-bottom:15px">
                  <?php echo $shipping_address->address; ?><br>
                  <?php echo $city.', '.$state.', '.$country.' '.$shipping_address->zip_code; ?><br>
                  <?php echo '+'.$shipping_address->country_code.' '.$shipping_address->phone_no; ?><br>
               </p>
            </td>
         </tr>
         <?php } ?>
         <tr>
            <td>
               <p style="font-size:14px;color:#000000;font-weight:400;text-align:left;font-family:'Poppins',sans-serif;margin:0;padding-bottom:15px">You may contact us on <a href="mailto:<?php echo get_option_url('EMAIl'); ?>" target="_blank"><?php echo get_option_url('EMAIl'); ?></a> if you any questions</p>
            </td>
         </tr>
      </tbody>
   </table>
</div>