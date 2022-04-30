<?php 
    $mail_success_payment1->Subject = 'Zimarex Order Summary (Order# '.$result["order_id"].')';
    $message4 = ' 
    
            <html lang="en">
                <head>  
                      
                    <link rel="stylesheet"  href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;1,100;1,200;1,300;1,400&display=swap" />
                    <link rel="preconnect"  href="https://fonts.gstatic.com">
                    
                    <style>
                    
                       body{
                            font-family: \'poppins\', sans-serif;
                            font-size: 0.96em;
                            line-height: 150%;
                       }
                       
                       p{
                            font-size: 0.96em;
                       }
                       
                       h4{
                            font-size: 1.1em;
                       }
                       
                        main{
                            width: 55%;
                            margin: 0 auto;
                        }
                        
                        @media only screen and (max-width: 1000px)  {
                          main {
                                width: 100%; 
                                margin: 0 auto;
                          }
                        }
                        
                        table {
                            border-collapse: collapse;
                            width: 100%;
                            font-size: 0.96em;
                        }
                        
                        td, th {
                            border: 1px solid #dddddd;
                            text-align: left;
                            padding: 8px;
                        }
                        
                        tr:nth-child(even) {
                            background-color: #dddddd;
                        }
                    </style>
                </head>
                
                <body>
                    <main>
                        <div class="welcome-msg">
                            <p>
                                Dear '.$result["name"].',
                                <br>  <br>
                                Thank you for choosing Zimarex. Here\'s a summary of your order.
                            </p>
                            
                            <h4>Order Details</h4>
                            <p> <b> Order Date :  </b> '.$result["date_init"].' </p>
                            <p> <b> Order Number :  </b> '.$result["order_id"].' </p>
                            <p> <b> Transaction ID :  </b> '.$result["tran_id"].' </p>
                            <p> <b> Address :  </b> '.$result["address1"].', '.$result["address2"].' </p>
                            <p> <b> Payment Source :  </b> '.$result["name"].' </p>
                            <p> <b> Total :  </b> ₦'.$result["amount"].' </p>
                        </div>
                        
                        <div class="order-msg">
                            <table>
                              <tr>
                                <th>Item Name</th>
                                <th>Qty</th>
                                <th>Price</th>
                              </tr>'.$msgg
                              .'<tr>
                                  <td> Transaction Fee</td>
                                  <td> - </td>
                                  <td> ₦50.00</td>
                              </tr>
                              <tr>
                                  <th colspan="2"> Total</th>
                                  <td> ₦'.$result["amount"].'</td>
                              </tr>
                            </table>
                        </div>
                        
                         <div class="order-break-msg">
                            
                        </div>
                        
                        <p>Your Goods would be delivered to the address stated above, for more enquire and information please contact us <br><br>
                        +234 813 338 1982 <br>
                        support@zimarex.com</p>
                    </main>
                </body>
                
            </html>
        ';
        
        $mail_success_payment1->setFrom('support@zimarex.com', 'Zimarex');
        
        $mail_success_payment1->addAddress($result['email']);               // Name is optional
        $mail_success_payment1->addReplyTo('support@zimarex.com', 'Zimarex');
        
        $mail_success_payment1->isHTML(true);                             
        $mail_success_payment1->Body = $message4;
        //$mail_success_payment1->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $mail_success_payment1->send();
 

?>