@extends('layouts.app')

@push('styles')
<style>
  body {
    background: url("{{ asset('images/fondo.jpg') }}") no-repeat center center fixed;
    background-size: cover;
  }

  body::before {
    content: "";
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(255, 255, 255, 0.6);
    pointer-events: none;
    z-index: -1;
  }

  .contact-card {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(8px);
    border-radius: 1rem;
    padding: 2rem;
    max-width: 400px;
    margin: 4rem auto;
    align-items: center;
    display: grid;
    gap: 0.75rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    text-align: center;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .contact-card h2 {
    font-weight: 700;
    font-size: 2rem;
    color: #1d1d1d;
    margin-bottom: 1rem;
    letter-spacing: 0.05em;
  }

  .contact-card p {
    font-weight: 500;
    font-size: 1.1rem;
    color: #333;
    margin: 0.25rem 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
  }

  .contact-card p span {
    font-weight: 700;
  }

  .contact-card i {
    background-color: #28a745;
    color: white;
    font-size: 1.2rem;
    width: 40px;
    height: 40px;
    line-height: 28px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 28px;
  }

  a {
    color: #0066cc;
    text-decoration: none;
  }
  a:hover {
    text-decoration: underline;
  }
</style>

<link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
  rel="stylesheet"
/>
@endpush

@section('title', 'Contáctanos')

@section('content')
  <div class="contact-card" role="main" aria-label="Información de contacto">
    <h2>CONTACTANOS:</h2>

    <p>
      <i class="fa-solid fa-user"></i>
      <span>@NUTRITÚ</span>
    </p>

    <p>
      <i class="fa-solid fa-phone"></i>
      15-1234-5678 / 1234-5678
    </p>

    <p>
      <i class="fa-solid fa-globe"></i>
      <a href="https://www.nutritú.com" target="_blank" rel="noopener noreferrer">WWW.NUTRITÚ.COM.</a>
    </p>

    <p>
      <i class="fa-solid fa-envelope"></i>
      <a href="mailto:hola@nutritú.com">HOLA@NUTRITÚ.COM</a>
    </p>
  </div>
@endsection
