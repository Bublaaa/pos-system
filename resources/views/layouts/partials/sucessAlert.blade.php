@if (Session::has('success'))
<div id="alertContainer" class="alert alert-success">
    {{Session::get('success')}}
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