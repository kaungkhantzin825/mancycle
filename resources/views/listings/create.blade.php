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
                    
                    <!-- Location Selection -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">
                                Region/State <span style="color: #ef4444;">*</span>
                            </label>
                            <select id="region_id" name="region_id" required
                                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;">
                                <option value="">Select Region/State</option>
                                @foreach($parentLocations as $location)
                                <option value="{{ $location->id }}" {{ old('region_id') == $location->id ? 'selected' : '' }}>
                                    {{ $location->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">
                                City <span style="color: #ef4444;">*</span>
                            </label>
                            <select id="location_id" name="location_id" required
                                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;"
                                    disabled>
                                <option value="">First select Region</option>
                            </select>
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">
                            Detailed Address
                        </label>
                        <input type="text" name="detailed_address" value="{{ old('detailed_address') }}"
                               style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;"
                               placeholder="Street address, building name, etc.">
                    </div>
                    
                    <!-- Coordinates Section -->
                    <div style="margin-bottom: 1.5rem;">
                        <h4 style="color: #374151; margin-bottom: 1rem; font-weight: 600;">Location Coordinates (Optional)</h4>
                        <div style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 1rem; align-items: end;">
                            <div>
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Latitude</label>
                                <input type="number" id="latitude" name="latitude" value="{{ old('latitude') }}"
                                       step="any" min="-90" max="90"
                                       style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;"
                                       placeholder="e.g., 16.8661">
                            </div>
                            
                            <div>
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Longitude</label>
                                <input type="number" id="longitude" name="longitude" value="{{ old('longitude') }}"
                                       step="any" min="-180" max="180"
                                       style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;"
                                       placeholder="e.g., 96.1951">
                            </div>
                            
                            <div>
                                <button type="button" id="get_location_btn"
                                        style="padding: 0.75rem 1rem; background: #10b981; color: white; border: none; border-radius: 0.5rem; font-weight: 500; cursor: pointer; white-space: nowrap;">
                                    Get My Location
                                </button>
                            </div>
                        </div>
                        <small style="color: #6b7280; margin-top: 0.5rem; display: block;">Coordinates help buyers find your exact location. Click "Get My Location" to auto-fill.</small>
                    </div>
                    
                    <!-- Legacy Location Field (for backward compatibility) -->
                    <input type="hidden" id="location_text" name="location" value="{{ old('location') }}" required>
                    
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const regionSelect = document.getElementById('region_id');
    const locationIdSelect = document.getElementById('location_id');
    const locationTextField = document.getElementById('location_text');
    const getLocationBtn = document.getElementById('get_location_btn');
    const latitudeField = document.getElementById('latitude');
    const longitudeField = document.getElementById('longitude');
    
    // Handle Region change
    regionSelect.addEventListener('change', function() {
        const regionId = this.value;
        
        // Reset city select
        locationIdSelect.innerHTML = '<option value="">Select City</option>';
        locationIdSelect.disabled = true;
        
        if (!regionId) {
            updateLocationText();
            return;
        }
        
        // Show loading state
        locationIdSelect.innerHTML = '<option value="">Loading cities...</option>';
        
        // Fetch "cities" (townships under the region's city)
        console.log('Fetching townships for region ID:', regionId);
        fetch(`/api/locations/descendants?region_id=${regionId}`)
            .then(response => {
                console.log('Descendants response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Descendants received data:', data);
                locationIdSelect.innerHTML = '<option value="">Select City</option>';
                
                if (data && data.length > 0) {
                    console.log('Adding', data.length, 'items to City dropdown');
                    data.forEach(location => {
                        const option = document.createElement('option');
                        option.value = location.id;
                        option.textContent = location.name; // e.g., Insein, Hlaing, etc.
                        locationIdSelect.appendChild(option);
                        console.log('Added City item:', location.name);
                    });
                    locationIdSelect.disabled = false; // enable dropdown
                } else {
                    console.log('No descendants found for region');
                    locationIdSelect.innerHTML = '<option value="">No cities available</option>';
                }
                
                updateLocationText();
            })
            .catch(error => {
                console.error('Error fetching descendants:', error);
                locationIdSelect.innerHTML = '<option value="">Error loading cities</option>';
                alert('Failed to load cities. Error: ' + error.message);
            });
    });
    
    // Handle City selection
    locationIdSelect.addEventListener('change', function() {
        updateLocationText();
    });
    
    // Function to update the location text field
    function updateLocationText() {
        const regionText = regionSelect.options[regionSelect.selectedIndex]?.text || '';
        const cityText = locationIdSelect.options[locationIdSelect.selectedIndex]?.text || '';
        
        let locationParts = [];
        
        if (cityText && cityText !== 'Select City' && cityText !== 'No cities available' && cityText !== 'First select Region' && cityText !== 'Loading cities...' && cityText !== 'Error loading cities') {
            locationParts.push(cityText);
        }
        if (regionText && regionText !== 'Select Region/State') {
            locationParts.push(regionText);
        }
        
        locationTextField.value = locationParts.join(', ');
    }
    
    // Handle Get My Location button
    getLocationBtn.addEventListener('click', function() {
        if (!navigator.geolocation) {
            alert('Geolocation is not supported by your browser');
            return;
        }
        
        // Show loading state
        this.textContent = 'Getting location...';
        this.disabled = true;
        
        navigator.geolocation.getCurrentPosition(
            function(position) {
                // Success callback
                latitudeField.value = position.coords.latitude.toFixed(6);
                longitudeField.value = position.coords.longitude.toFixed(6);
                
                // Reset button
                getLocationBtn.textContent = 'Get My Location';
                getLocationBtn.disabled = false;
                
                // Show success message
                const successMsg = document.createElement('div');
                successMsg.style.cssText = 'color: #10b981; margin-top: 0.5rem; font-size: 0.875rem;';
                successMsg.textContent = '✓ Location coordinates obtained successfully!';
                getLocationBtn.parentNode.appendChild(successMsg);
                
                // Remove success message after 3 seconds
                setTimeout(() => successMsg.remove(), 3000);
            },
            function(error) {
                // Error callback
                let errorMessage = 'Unable to get location. ';
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        errorMessage += 'Permission denied.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMessage += 'Location information unavailable.';
                        break;
                    case error.TIMEOUT:
                        errorMessage += 'Request timed out.';
                        break;
                    default:
                        errorMessage += 'An unknown error occurred.';
                }
                
                alert(errorMessage);
                
                // Reset button
                getLocationBtn.textContent = 'Get My Location';
                getLocationBtn.disabled = false;
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    });
    
    // Load old values if they exist (for form validation errors)
    const oldRegionId = '{{ old("region_id") }}';
    const oldCityId = '{{ old("city_id") }}';
    const oldLocationId = '{{ old("location_id") }}';
    
    if (oldRegionId && regionSelect.value) {
        // Trigger region change to load cities
        regionSelect.dispatchEvent(new Event('change'));
        
        // Wait for cities to load, then select old city
        setTimeout(() => {
            if (oldCityId) {
                citySelect.value = oldCityId;
                citySelect.dispatchEvent(new Event('change'));
                
                // Wait for townships to load, then select old township
                setTimeout(() => {
                    if (oldLocationId) {
                        locationIdSelect.value = oldLocationId;
                        updateLocationText();
                    }
                }, 500);
            }
        }, 500);
    }
});
</script>
@endpush
