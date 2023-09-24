@extends('layouts.plantilla')
@section('title','Busqueda QR')

@section('content')
    <div id="reader"></div>
    <div id="result"></div>
@endsection

@push('scripts')
    <script>
        console.log(Html5QrcodeScanner);

        const scanner = new Html5QrcodeScanner('reader',{
            qrbox:{
                width: 250,
                height: 250
            },
            fps: 20,
            videoConstraints: {
                facingMode: { exact: "environment" },
            },
        });

        scanner.render(success,error);

        function success(result){
            // Redirigimos al buen enlace no?

            window.location.href = result;

            scanner.clear();
            document.getElementById('reader').remove();
        }

        function error(err){
            console.log(err);
        }
    </script>
@endpush