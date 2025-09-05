@extends('layouts.mancycle')

@section('title', 'Create New Listing - ManCycle')

@section('content')
<!-- Page Header -->
<section style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 3rem 0;">
    <div class="container">
        <h1 style="color: white; font-size: 2.5rem; font-weight: 700; margin-bottom: 0.5rem;">Create New Listing</h1>
        <p style="color: rgba(255, 255, 255, 0.9);">List your vehicle and reach thousands of potential buyers</p>
    </div>
</section>

<!-- Create Listing Form -->
<section style="padding: 3rem 0; background: #f8fafc;">
    <div class="container">
        <div style="max-width: 800px; margin: 0 auto;">
            @if($errors->any())
            <div style="background: #fee2e2; border-left: 4px solid #ef4444; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                <h4 style="color: #991b1b; margin-bottom: 0.5rem;">Please correct the following errors:</h4>
                <ul style="margin: 0; padding-left: 1.5rem;">
                    @foreach($errors->all() as $error)
                    <li style="color: #991b1b;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('listings.store') }}" enctype="multipart/form-data" style="background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                @csrf
                
                <!-- Basic Information -->
                <div style="margin-bottom: 2rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e5e7eb;">
                        Basic Information
                    </h3>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">
                            Listing Title <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="title" value="{{ old('title') }}" required
                               style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;"
                               placeholder="e.g., 2020 Honda Civic LX - Excellent Condition">
                    </div>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">
                            Category <span style="color: #ef4444;">*</span>
                        </label>
                        <select name="category_id" required
                                style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;">
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->parent ? $category->parent->name . ' - ' : '' }}{{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">
                            Description <span style="color: #ef4444;">*</span>
                        </label>
                        <textarea name="description" rows="6" required
                                  style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem; resize: vertical;"
                                  placeholder="Describe your vehicle in detail. Include features, condition, any modifications, service history, etc.">{{ old('description') }}</textarea>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">
                                Price <span style="color: #ef4444;">*</span>
                            </label>
                            <div style="position: relative;">
                                <span style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: #6b7280;">$</span>
                                <input type="number" name="price" value="{{ old('price') }}" required min="0" step="0.01"
                                       style="width: 100%; padding: 0.75rem 0.75rem 0.75rem 2rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;"
                                       placeholder="0.00">
                            </div>
                        </div>
                        
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">
                                Condition <span style="color: #ef4444;">*</span>
                            </label>
                            <select name="condition" required
                                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;">
                                <option value="">Select condition</option>
                                <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>New</option>
                                <option value="excellent" {{ old('condition') == 'excellent' ? 'selected' : '' }}>Excellent</option>
                                <option value="good" {{ old('condition') == 'good' ? 'selected' : '' }}>Good</option>
                                <option value="fair" {{ old('condition') == 'fair' ? 'selected' : '' }}>Fair</option>
                                <option value="poor" {{ old('condition') == 'poor' ? 'selected' : '' }}>Poor</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Vehicle Details -->
                <div style="margin-bottom: 2rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e5e7eb;">
                        Vehicle Details
                    </h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Brand</label>
                            <input type="text" name="brand" value="{{ old('brand') }}"
                                   style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;"
                                   placeholder="e.g., Honda">
                        </div>
                        
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Model</label>
                            <input type="text" name="model" value="{{ old('model') }}"
                                   style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;"
                                   placeholder="e.g., Civic">
                        </div>
                        
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Year</label>
                            <input type="number" name="year" value="{{ old('year') }}" min="1900" max="{{ date('Y') + 1 }}"
                                   style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;"
                                   placeholder="e.g., 2020">
                        </div>
                        
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Mileage</label>
                            <input type="number" name="mileage" value="{{ old('mileage') }}" min="0"
                                   style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;"
                                   placeholder="e.g., 25000">
                        </div>
                        
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Fuel Type</label>
                            <select name="fuel_type"
                                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;">
                                <option value="">Select fuel type</option>
                                <option value="gasoline" {{ old('fuel_type') == 'gasoline' ? 'selected' : '' }}>Gasoline</option>
                                <option value="diesel" {{ old('fuel_type') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                <option value="electric" {{ old('fuel_type') == 'electric' ? 'selected' : '' }}>Electric</option>
                                <option value="hybrid" {{ old('fuel_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                            </select>
                        </div>
                        
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Transmission</label>
                            <select name="transmission"
                                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;">
                                <option value="">Select transmission</option>
                                <option value="automatic" {{ old('transmission') == 'automatic' ? 'selected' : '' }}>Automatic</option>
                                <option value="manual" {{ old('transmission') == 'manual' ? 'selected' : '' }}>Manual</option>
                                <option value="cvt" {{ old('transmission') == 'cvt' ? 'selected' : '' }}>CVT</option>
                            </select>
                        </div>
                        
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Color</label>
                            <input type="text" name="color" value="{{ old('color') }}"
                                   style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;"
                                   placeholder="e.g., Silver">
                        </div>
                    </div>
                </div>
                
                <!-- Contact Information -->
                <div style="margin-bottom: 2rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e5e7eb;">
                        Contact Information
                    </h3>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">
                            Location <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="location" value="{{ old('location') }}" required
                               style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;"
                               placeholder="e.g., Los Angeles, CA">
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem;">
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">
                                Contact Phone
                            </label>
                            <input type="tel" name="contact_phone" value="{{ old('contact_phone', auth()->user()->phone) }}"
                                   style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;"
                                   placeholder="(555) 123-4567">
                        </div>
                        
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">
                                Phone Privacy
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.75rem; cursor: pointer;">
                                <input type="checkbox" name="phone_privacy" value="1" {{ old('phone_privacy') ? 'checked' : '' }}
                                       style="width: 1.25rem; height: 1.25rem;">
                                <span>Hide my phone number</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Images -->
                <div style="margin-bottom: 2rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e5e7eb;">
                        Images
                    </h3>
                    
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">
                            Upload Images
                        </label>
                        <input type="file" name="images[]" multiple accept="image/*"
                               style="width: 100%; padding: 0.75rem; border: 2px dashed #d1d5db; border-radius: 0.5rem; background: #f9fafb;">
                        <small style="color: #6b7280;">Upload up to 10 images. First image will be the main image.</small>
                    </div>
                </div>
                
                <!-- Submit Buttons -->
                <div style="display: flex; gap: 1rem; justify-content: flex-end; padding-top: 1.5rem; border-top: 2px solid #e5e7eb;">
                    <a href="{{ route('dashboard') }}" 
                       style="padding: 0.75rem 1.5rem; background: white; color: #6b7280; border: 1px solid #d1d5db; border-radius: 0.5rem; text-decoration: none; font-weight: 500;">
                        Cancel
                    </a>
                    <button type="submit" 
                            style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer;">
                        Create Listing
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
