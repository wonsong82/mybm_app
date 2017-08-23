{{-- Dropdown Backpack CRUD filter --}}

<li filter-name="{{ $filter->name }}"
	filter-type="{{ $filter->type }}"
	class="dropdown {{ Request::get($filter->name)?'active active-custom':'' }}">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $filter->label }} <span class="caret"></span></a>
    <ul class="dropdown-menu">
		<li><a parameter="{{ $filter->name }}" key="" href="">-</a></li>
		<li role="separator" class="divider"></li>
		@if (is_array($filter->values) && count($filter->values))
			@foreach($filter->values as $key => $value)
				@if ($key === 'dropdown-separator')
					<li role="separator" class="divider"></li>
				@else
					<li class="{{ ($filter->isActive() && $filter->currentValue == $key)?'active active-custom':'' }}">
						<a  parameter="{{ $filter->name }}"
							href=""
							key="{{ $key }}"
							>{{ $value }}</a>
					</li>
				@endif
			@endforeach
		@endif
    </ul>
  </li>


{{-- ########################################### --}}
{{-- Extra CSS and JS for this particular filter --}}

{{-- FILTERS EXTRA CSS  --}}
{{-- push things in the after_styles section --}}

@push('crud_list_styles')
<style>
	.dropdown-menu>.active>a,
	.dropdown-menu>.active>a:focus,
	.dropdown-menu>.active>a:hover {
		color: #777; /* #fff, #337ab7 */
		background-color: transparent;
	}
	.navbar-default .navbar-nav>.active>a,
	.navbar-default .navbar-nav>.active>a:focus,
	.navbar-default .navbar-nav>.active>a:hover {
		color: #333;
		background-color: transparent;
	}
	.dropdown-menu>.active-custom>a,
	.dropdown-menu>.active-custom>a:focus,
	.dropdown-menu>.active-custom>a:hover {
		color: #fff;
		background-color: #337ab7;
	}
	.navbar-default .navbar-nav>.active-custom>a,
	.navbar-default .navbar-nav>.active-custom>a:focus,
	.navbar-default .navbar-nav>.active-custom>a:hover {
		color: #555;
		background-color: #e7e7e7;
	}

</style>
@endpush


{{-- FILTERS EXTRA JS --}}
{{-- push things in the after_scripts section --}}

@push('crud_list_scripts')
    <script>
		jQuery(document).ready(function($) {
			$("li.dropdown[filter-name={{ $filter->name }}] .dropdown-menu li a").click(function(e) {
				e.preventDefault();

				var value = $(this).attr('key');
				var parameter = $(this).attr('parameter');

				@if (!$crud->ajaxTable())
					// behaviour for normal table
					var current_url = normalizeAmpersand('{{ Request::fullUrl() }}');
					var new_url = addOrUpdateUriParameter(current_url, parameter, value);

					// refresh the page to the new_url
					new_url = normalizeAmpersand(new_url.toString());
			    	window.location.href = new_url;
			    @else
			    	// behaviour for ajax table
					var ajax_table = $("#crudTable").DataTable();
					var current_url = ajax_table.ajax.url();
					var new_url = addOrUpdateUriParameter(current_url, parameter, value);

					// replace the datatables ajax url with new_url and reload it
					new_url = normalizeAmpersand(new_url.toString());
					ajax_table.ajax.url(new_url).load();

					// mark this filter as active in the navbar-filters
					// mark dropdown items active accordingly
					if (URI(new_url).hasQuery('{{ $filter->name }}', true)) {
						$("li[filter-name={{ $filter->name }}]").removeClass('active').removeClass('active-custom').addClass('active').addClass('active-custom');
						$("li[filter-name={{ $filter->name }}] .dropdown-menu li").removeClass('active').removeClass('active-custom');
						$(this).parent().addClass('active').addClass('active-custom');
					}
					else
					{
						$("li[filter-name={{ $filter->name }}]").trigger("filter:clear");
					}
			    @endif
			});

			// clear filter event (used here and by the Remove all filters button)
			$("li[filter-name={{ $filter->name }}]").on('filter:clear', function(e) {
				// console.log('dropdown filter cleared');
				$("li[filter-name={{ $filter->name }}]").removeClass('active').removeClass('active-custom');
				$("li[filter-name={{ $filter->name }}] .dropdown-menu li").removeClass('active').removeClass('active-custom');
			});
		});
	</script>
@endpush
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
