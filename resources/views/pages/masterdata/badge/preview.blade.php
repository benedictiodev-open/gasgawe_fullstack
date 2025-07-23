<!-- Fullscreen Image Preview Modal -->
<div x-show="isImagePreviewOpen" x-transition @click.self="closeImagePreview"
  class="fixed inset-0 bg-black/70 z-50 flex items-center justify-center" x-cloak>
  <img :src="previewImageUrl" class="max-w-full max-h-screen rounded-lg shadow-lg border-4 border-white"
    alt="Full Preview" />
  <button class="absolute top-5 right-5 text-white text-xl font-bold" @click="closeImagePreview">
    &times;
  </button>
</div>
