<?php
header("Content-Type: application/json");

$email = $_POST['partnerUserID'] ?? '';
$password = $_POST['partnerUserSecret'] ?? '';

$data = [
    "partnerName"      => "applicant",
    "partnerPassword"  => "d7c3119c6cdab02d68d9",
    "partnerUserID"    => $email,
    "partnerUserSecret"=> $password
];

$ch = curl_init("https://www.expensify.com/api/Authenticate");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "expensifyengineeringcandidate: xyz" 
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

$response = curl_exec($ch);
curl_close($ch);


// echo raw JSON back to the browser
echo $response;



// $(function(){
  
//   // Handle form submit.
//   $('#params').submit(function(){
//     var proxy = '../../ba-simple-proxy.php',
//       url = proxy + '?' + $('#params').serialize();
    
//     // Update some stuff.
//     $('#request').html( $('<a/>').attr( 'href', url ).text( url ) );
//     $('#response').html( 'Loading...' );
    
//     // Test to see if HTML mode.
//     if ( /mode=native/.test( url ) ) {
      
//       // Make GET request.
//       $.get( url, function(data){
        
//         $('#response')
//           .html( '<pre class="brush:xml"/>' )
//           .find( 'pre' )
//             .text( data );
        
//         SyntaxHighlighter.highlight();
//       });
      
//     } else {
      
//       // Make JSON request.
//       $.getJSON( url, function(data){
        
//         $('#response')
//           .html( '<pre class="brush:js"/>' )
//           .find( 'pre' )
//             .text( JSON.stringify( data, null, 2 ) );
        
//         SyntaxHighlighter.highlight();
//       });
//     }
    
//     // Prevent default form submit action.
//     return false;
//   });
  
//   // Submit the form on page load if ?url= is passed into the example page.
//   if ( $('#url').val() !== '' ) {
//     $('#params').submit();
//   }
  
//   // Disable AJAX caching.
//   $.ajaxSetup({ cache: false });
  
//   // Disable dependent checkboxes as necessary.
//   $('input:radio').click(function(){
//     var that = $(this),
//       c1 = 'dependent-' + that.attr('name'),
//       c2 = c1 + '-' + that.val();
    
//     that.closest('form')
//       .find( '.' + c1 + ' input' )
//         .attr( 'disabled', 'disabled' )
//         .end()
//       .find( '.' + c2 + ' input' )
//         .removeAttr( 'disabled' );
//   });
  
//   // Clicking sample remote urls should populate the "Remote URL" box.
//   $('#sample a').click(function(){
//     $('#url').val( $(this).attr( 'href' ) );
//     return false;
//   });
// }); 