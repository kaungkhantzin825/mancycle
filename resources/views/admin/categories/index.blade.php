@extends('layouts.admin')

@section('title', 'Categories Management')

@section('content')
<!-- Page Header -->
<div style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 1.875rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem;">Categories Management</h1>
            <p style="color: #6b7280;">Manage listing categories and subcategories</p>
        </div>
        <button onclick="showAddCategoryModal()" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Add New Category
        </button>
    </div>
</div>

<!-- Category Types Tabs -->
<div style="display: flex; gap: 1rem; margin-bottom: 2rem; border-bottom: 2px solid #e5e7eb;">
    <button class="tab-button active" onclick="filterByType('all')" data-type="all" 
            style="padding: 0.75rem 1.5rem; background: none; border: none; font-weight: 600; color: #ef4444; border-bottom: 2px solid #ef4444; cursor: pointer;">
        All Categories
    </button>
    <button class="tab-button" onclick="filterByType('cars')" data-type="cars"
            style="padding: 0.75rem 1.5rem; background: none; border: none; font-weight: 600; color: #6b7280; cursor: pointer;">
        Cars
    </button>
    <button class="tab-button" onclick="filterByType('motorcycles')" data-type="motorcycles"
            style="padding: 0.75rem 1.5rem; background: none; border: none; font-weight: 600; color: #6b7280; cursor: pointer;">
        Motorcycles
    </button>
    <button class="tab-button" onclick="filterByType('second_hand')" data-type="second_hand"
            style="padding: 0.75rem 1.5rem; background: none; border: none; font-weight: 600; color: #6b7280; cursor: pointer;">
        Second Hand
    </button>
</div>

<!-- Categories Grid -->
<div class="categories-container">
    @foreach($categories->where('parent_id', null) as $category)
    <div class="category-card" data-type="{{ $category->type }}" style="background: white; border-radius: 0.75rem; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 1rem;">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div style="flex: 1;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                    @if($category->icon)
                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: white;">
                        <i class="{{ $category->icon }}"></i>
                    </div>
                    @endif
                    <div>
                        <h3 style="font-size: 1.125rem; font-weight: 600; color: #1f2937;">{{ $category->name }}</h3>
                        <span style="padding: 0.125rem 0.5rem; background: #f3f4f6; border-radius: 0.25rem; font-size: 0.75rem; color: #6b7280;">
                            {{ ucfirst($category->type) }}
                        </span>
                    </div>
                </div>
                
                @if($category->description)
                <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1rem;">{{ $category->description }}</p>
                @endif
                
                <div style="display: flex; gap: 1rem; font-size: 0.875rem; color: #6b7280;">
                    <span><i class="fas fa-list"></i> {{ $category->listings_count ?? 0 }} listings</span>
                    <span><i class="fas fa-layer-group"></i> {{ $category->children->count() }} subcategories</span>
                    <span>
                        @if($category->is_active)
                        <span style="color: #10b981;"><i class="fas fa-check-circle"></i> Active</span>
                        @else
                        <span style="color: #ef4444;"><i class="fas fa-times-circle"></i> Inactive</span>
                        @endif
                    </span>
                </div>
                
                <!-- Subcategories -->
                @if($category->children->count() > 0)
                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                    <h4 style="font-size: 0.875rem; font-weight: 600; color: #6b7280; margin-bottom: 0.5rem;">Subcategories:</h4>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                        @foreach($category->children as $child)
                        <span style="padding: 0.25rem 0.75rem; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 1rem; font-size: 0.75rem;">
                            {{ $child->name }}
                            <button onclick="editCategory({{ $child->id }})" style="margin-left: 0.25rem; background: none; border: none; color: #6b7280; cursor: pointer;">
                                <i class="fas fa-edit"></i>
                            </button>
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            
            <div style="display: flex; gap: 0.5rem;">
                <button onclick="editCategory({{ $category->id }})" class="btn btn-sm" 
                        style="padding: 0.5rem; font-size: 0.875rem; background: #f59e0b; color: white;">
                    <i class="fas fa-edit"></i>
                </button>
                
                <form method="POST" action="{{ route('admin.categories.toggle', $category) }}" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-sm" 
                            style="padding: 0.5rem; font-size: 0.875rem; background: {{ $category->is_active ? '#ef4444' : '#10b981' }}; color: white;">
                        <i class="fas fa-{{ $category->is_active ? 'ban' : 'check' }}"></i>
                    </button>
                </form>
                
                @if($category->listings_count == 0 && $category->children->count() == 0)
                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" style="display: inline;"
                      onsubmit="return confirm('Are you sure you want to delete this category?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm" 
                            style="padding: 0.5rem; font-size: 0.875rem; background: #dc2626; color: white;">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Add/Edit Category Modal -->
<div id="categoryModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 1rem; padding: 2rem; max-width: 600px; width: 90%; max-height: 90vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 id="modalTitle" style="font-size: 1.25rem; font-weight: 700;">Add New Category</h3>
            <button onclick="hideCategoryModal()" style="background: none; border: none; font-size: 1.5rem; color: #6b7280; cursor: pointer;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="categoryForm" method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div style="display: grid; gap: 1rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Category Name *</label>
                    <input type="text" name="name" id="categoryName" required 
                           style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Slug *</label>
                    <input type="text" name="slug" id="categorySlug" required 
                           style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                    <small style="color: #6b7280;">URL-friendly version of the name</small>
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Description</label>
                    <textarea name="description" id="categoryDescription" 
                              style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; min-height: 80px;"></textarea>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Type *</label>
                        <select name="type" id="categoryType" required 
                                style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            <option value="cars">Cars</option>
                            <option value="motorcycles">Motorcycles</option>
                            <option value="second_hand">Second Hand</option>
                        </select>
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Parent Category</label>
                        <select name="parent_id" id="parentCategory" 
                                style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            <option value="">None (Top Level)</option>
                            @foreach($categories->where('parent_id', null) as $parent)
                            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Icon Class</label>
                    <input type="text" name="icon" id="categoryIcon" placeholder="fas fa-car" 
                           style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                    <small style="color: #6b7280;">Font Awesome icon class (e.g., fas fa-car)</small>
                </div>
                
                <div>
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="is_active" id="categoryActive" checked>
                        <span style="font-weight: 600;">Active</span>
                    </label>
                    <small style="color: #6b7280;">Inactive categories won't be shown to users</small>
                </div>
                
                <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                    <button type="button" onclick="hideCategoryModal()" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Category</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Tab filtering
function filterByType(type) {
    const tabs = document.querySelectorAll('.tab-button');
    const cards = document.querySelectorAll('.category-card');
    
    // Update active tab
    tabs.forEach(tab => {
        if (tab.dataset.type === type) {
            tab.classList.add('active');
            tab.style.color = '#ef4444';
            tab.style.borderBottom = '2px solid #ef4444';
        } else {
            tab.classList.remove('active');
            tab.style.color = '#6b7280';
            tab.style.borderBottom = 'none';
        }
    });
    
    // Filter categories
    cards.forEach(card => {
        if (type === 'all' || card.dataset.type === type) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Modal functions
function showAddCategoryModal() {
    const modal = document.getElementById('categoryModal');
    const form = document.getElementById('categoryForm');
    const title = document.getElementById('modalTitle');
    
    title.textContent = 'Add New Category';
    form.action = '{{ route("admin.categories.store") }}';
    document.getElementById('formMethod').value = 'POST';
    form.reset();
    
    modal.style.display = 'flex';
}

function editCategory(categoryId) {
    // In a real application, you would fetch the category data via AJAX
    // For now, we'll just show the modal
    const modal = document.getElementById('categoryModal');
    const form = document.getElementById('categoryForm');
    const title = document.getElementById('modalTitle');
    
    title.textContent = 'Edit Category';
    form.action = `/admin/categories/${categoryId}`;
    document.getElementById('formMethod').value = 'PATCH';
    
    // You would populate the form fields with the category data here
    
    modal.style.display = 'flex';
}

function hideCategoryModal() {
    const modal = document.getElementById('categoryModal');
    modal.style.display = 'none';
}

// Auto-generate slug from name
document.getElementById('categoryName')?.addEventListener('input', function(e) {
    const slug = e.target.value
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
    document.getElementById('categorySlug').value = slug;
});

// Close modal when clicking outside
document.getElementById('categoryModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        hideCategoryModal();
    }
});
</script>
@endpush

@push('styles')
<style>
.category-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.category-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.tab-button {
    transition: color 0.2s ease;
}

.tab-button:hover {
    color: #ef4444 !important;
}
</style>
@endpush
@endsection
