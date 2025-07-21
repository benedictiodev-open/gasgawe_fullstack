@props([
    'label' => '',
    'error' => false,
])

<label class="form-control w-full">
  <div class="label">
    <span class="label-text">{{ $label }}</span>
  </div>
  <input type="text"
    {{ $attributes->merge(['class' => 'input input-bordered w-full input-sm text-base-content']) }} />
  @if ($error)
    <div class="label">
      <span class="label-text-alt text-error">{{ $error }}</span>
    </div>
  @endif
</label>
