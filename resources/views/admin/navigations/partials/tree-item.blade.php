@if($navigation && isset($navigation->id))

<div class="tree-item tree-level-{{ $level ?? 0 }}"
     data-id="{{ $navigation->id ?? '' }}"
     data-parent-id="{{ $navigation->parent_id ?? '' }}">

    <div class="tree-content">
        <input type="checkbox" class="form-check-input navigation-checkbox tree-checkbox"
               value="{{ $navigation->id ?? '' }}" id="nav-{{ $navigation->id ?? '' }}">

        <div class="tree-drag-handle">
            <i class="fas fa-grip-vertical"></i>
        </div>

        @if(isset($navigation->icon) && $navigation->icon)
            <div class="tree-icon">
                <i class="{{ $navigation->icon }}"></i>
            </div>
        @endif

        <div class="tree-info">
            <div class="tree-label">{{ $navigation->label ?? 'Untitled' }}</div>
            <div class="tree-url">
                @if(isset($navigation->page) && $navigation->page)
                    <span class="badge bg-info me-2">Page: {{ $navigation->page->title }}</span>
                    {{ $navigation->page->slug === 'home' ? '/' : '/' . $navigation->page->slug }}
                @else
                    {{ $navigation->url ?? '#' }}
                @endif
            </div>
        </div>

        <div class="tree-meta">
            <span class="status-badge {{ ($navigation->is_active ?? true) ? 'status-active' : 'status-inactive' }}">
                {{ ($navigation->is_active ?? true) ? 'Active' : 'Inactive' }}
            </span>

            @if(($navigation->target ?? '_self') === '_blank')
                <small class="text-muted">
                    <i class="fas fa-external-link-alt" title="Opens in new tab"></i>
                </small>
            @endif

            <div class="tree-actions">
                {{-- View Site Action --}}
                @php
                    $viewUrl = '#';
                    if (isset($navigation->page) && $navigation->page) {
                        $viewUrl = $navigation->page->slug === 'home' ? route('home') : route('page.show', $navigation->page->slug);
                    } elseif ($navigation->url) {
                        $viewUrl = $navigation->url;
                    }
                @endphp

                @if($viewUrl !== '#')
                    <a href="{{ $viewUrl }}"
                       class="btn btn-sm btn-outline-info"
                       title="View on Site"
                       target="{{ ($navigation->target ?? '_self') === '_blank' ? '_blank' : '_self' }}">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                @endif

                {{-- Edit Action --}}
                <a href="{{ route('admin.navigations.edit', $navigation->id ?? 0) }}"
                   class="btn btn-sm btn-outline-primary" title="Edit">
                    <i class="fas fa-edit"></i>
                </a>

                {{-- Toggle Status Action --}}
                <form action="{{ route('admin.navigations.toggle-status', $navigation->id ?? 0) }}"
                      method="POST" style="display: inline;">
                    @csrf
                    <button type="submit"
                            class="btn btn-sm {{ ($navigation->is_active ?? true) ? 'btn-outline-warning' : 'btn-outline-success' }}"
                            title="{{ ($navigation->is_active ?? true) ? 'Deactivate' : 'Activate' }}">
                        <i class="fas fa-{{ ($navigation->is_active ?? true) ? 'eye-slash' : 'eye' }}"></i>
                    </button>
                </form>

                @php
                    $childrenCount = 0;
                    if (isset($navigation->children)) {
                        $childrenCount = is_object($navigation->children) && method_exists($navigation->children, 'count')
                            ? $navigation->children->count()
                            : count($navigation->children ?? []);
                    }
                @endphp

                @if($childrenCount === 0)
                    <form action="{{ route('admin.navigations.destroy', $navigation->id ?? 0) }}"
                          method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                                class="btn btn-sm btn-outline-danger"
                                onclick="confirmDelete({{ $navigation->id ?? 0 }}, '{{ addslashes($navigation->label ?? 'Item') }}')"
                                title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                @else
                    <button type="button"
                            class="btn btn-sm btn-outline-secondary"
                            title="Cannot delete - has sub-items" disabled>
                        <i class="fas fa-lock"></i>
                    </button>
                @endif
            </div>
        </div>
    </div>

    @if($childrenCount > 0)
        <div class="tree-children">
            @foreach($navigation->children as $child)
                @include('admin.navigations.partials.tree-item', ['navigation' => $child, 'level' => ($level ?? 0) + 1])
            @endforeach
        </div>
    @endif
</div>
@endif
