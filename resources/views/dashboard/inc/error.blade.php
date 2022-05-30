<div id="error-screen-overlay"></div>
<div id='error-box'>
    <div id="error-content">
        <h1>Error!</h1>
        <h2>{{ $errors->first('action') }}</h2>
    </div>
    <div id='error-dismiss-container'>
        <button id="error-dismiss" class='btn btn-primary'>Dismiss</button>
    </div>
</div>