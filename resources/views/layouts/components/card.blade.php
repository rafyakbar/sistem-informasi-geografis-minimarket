<div class="card" {!! isset($id) ? 'id="'. $id . '"' : '' !!}>

    @isset($title)
    <div class="card-header border border-top-0 border-left-0 border-right-0">
        {{ $title }}

        @isset($action)
        <div class="card-actions">
            {{ $action }}
        </div>
        @endisset
    </div>
    @endisset
    
    <div class="card-body">
        {{ $slot }}
    </div>

    @isset($table)
    <div class="table-responsive">
        {{ $table }}
    </div>
    @endisset
    
    @isset($list)
        {{ $list }}
    @endisset

    @isset($footer)
    <div class="card-footer border border-bottom-0 border-left-0 border-right-0">
        {{ $footer }}
    </div>
    @endisset
    
</div>