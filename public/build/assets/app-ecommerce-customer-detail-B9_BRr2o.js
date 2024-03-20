(function(){const t=document.querySelector(".delete-customer");t&&(t.onclick=function(){Swal.fire({title:"Are you sure?",text:"You won't be able to revert customer!",icon:"warning",showCancelButton:!0,confirmButtonText:"Yes, Delete customer!",customClass:{confirmButton:"btn btn-primary me-2 waves-effect waves-light",cancelButton:"btn btn-label-secondary waves-effect waves-light"},buttonsStyling:!1}).then(function(e){e.value?Swal.fire({icon:"success",title:"Deleted!",text:"Customer has been removed.",customClass:{confirmButton:"btn btn-success waves-effect waves-light"}}):e.dismiss===Swal.DismissReason.cancel&&Swal.fire({title:"Cancelled",text:"Cancelled Delete :)",icon:"error",customClass:{confirmButton:"btn btn-success waves-effect waves-light"}})})});const s=document.querySelectorAll(".cancel-subscription");s&&s.forEach(e=>{e.onclick=function(){Swal.fire({text:"Are you sure you would like to cancel your subscription?",icon:"warning",showCancelButton:!0,confirmButtonText:"Yes",customClass:{confirmButton:"btn btn-primary me-2 waves-effect waves-light",cancelButton:"btn btn-label-secondary waves-effect waves-light"},buttonsStyling:!1}).then(function(n){n.value?Swal.fire({icon:"success",title:"Unsubscribed!",text:"Your subscription cancelled successfully.",customClass:{confirmButton:"btn btn-success waves-effect waves-light"}}):n.dismiss===Swal.DismissReason.cancel&&Swal.fire({title:"Cancelled",text:"Unsubscription Cancelled!!",icon:"error",customClass:{confirmButton:"btn btn-success waves-effect waves-light"}})})}})})();