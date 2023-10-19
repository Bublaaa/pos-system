@if (Session::has('error'))
<div id="alertContainer" class="alert alert-danger">
    {{Session::get('error')}}
</div>

<script>
// JavaScript code to hide the alert after 5 seconds
setTimeout(function() {
    var alertContainer = document.getElementById('alertContainer');
    if (alertContainer) {
        alertContainer.style.display = 'none';
    }
}, 5000);
</script>
@endif