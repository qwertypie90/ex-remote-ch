<?php
header("Content-Type: application/json");

$command = $_GET['command'] ?? 'Authenticate';

$data = [
    "partnerName"     => "applicant",
    "partnerPassword" => "d7c3119c6cdab02d68d9"
];

if ($command === "Authenticate") {
    // Login call requires email + password
    $data["partnerUserID"]     = $_POST["partnerUserID"] ?? '';
    $data["partnerUserSecret"] = $_POST["partnerUserSecret"] ?? '';
} elseif ($command === "Get") {
    // Forward whatever else JS sent (e.g. authToken, returnValueList)
    $data = array_merge($data, $_POST);
} elseif ($command === "CreateTransaction") {
   $data["merchant"] = $_POST["merch"] ?? '';  
    $data["amount"]   = $_POST["amount"] ?? '';  
    $data["created"]  = $_POST["date"] ?? '';   
    $data["authToken"] = $_POST["authToken"] ?? '';
}

$url = "https://www.expensify.com/api/" . $command;
$ch = curl_init($url);

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