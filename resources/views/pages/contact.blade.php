@extends('layouts.mancycle')

@section('title', 'Contact Us - ManCycle')

@section('content')
<section style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 4rem 0;">
    <div class="container">
        <h1 style="font-size: 3rem; font-weight: 700; text-align: center; margin-bottom: 1rem;">Contact Us</h1>
        <p style="font-size: 1.25rem; text-align: center; opacity: 0.9;">Get in touch with our team</p>
    </div>
</section>

<section style="padding: 4rem 0; background: white;">
    <div class="container">
        <div style="max-width: 600px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 3rem;">
                <h2 style="font-size: 2rem; margin-bottom: 1rem;">We'd love to hear from you</h2>
                <p style="color: #6b7280;">Send us a message and we'll respond as soon as possible.</p>
            </div>
            
            <div style="background: #f8fafc; padding: 2rem; border-radius: 1rem;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; text-align: center;">
                    <div>
                        <i class="fas fa-envelope" style="font-size: 2rem; color: #667eea; margin-bottom: 1rem;"></i>
                        <h3 style="margin-bottom: 0.5rem;">Email</h3>
                        <p style="color: #6b7280;">support@mancycle.com</p>
                    </div>
                    <div>
                        <i class="fas fa-phone" style="font-size: 2rem; color: #667eea; margin-bottom: 1rem;"></i>
                        <h3 style="margin-bottom: 0.5rem;">Phone</h3>
                        <p style="color: #6b7280;">+1 (555) 123-4567</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection