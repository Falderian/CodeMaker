<form method="get" action="{{ route('user.index') }}">
  <div class="row mb-3">
    @foreach ($filterOptions as $filterKey => $filter)
    <div class="col-md-3">
      <div class="form-group">
        <label for="{{ $filterKey }}">{{ ucfirst($filterKey) }}:</label>
        <select class="form-control" name="{{ $filterKey }}[]" multiple>
          @foreach ($filter as $optionKey => $optionValue)
          <option value="{{ $optionKey }}"
            {{ in_array($optionKey, $selectedFilters[$filterKey] ?? []) ? 'selected' : '' }}>
            {{ $optionValue }}</option>
          @endforeach
        </select>
      </div>
    </div>
    @endforeach
    <div class="col-md-3">
      <div class="d-flex flex-column">
        <button type="submit" class="btn btn-primary mt-4">Apply Filter</button>
        <a href="{{ route('user.index') }}" class="btn btn-secondary mt-4">Reset Filters</a>
      </div>
    </div>
  </div>
</form>
