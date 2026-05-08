/**
 * Shop JS - Custom interactions for product list & detail pages
 */

document.addEventListener('DOMContentLoaded', function () {

  // ============================
  // PRODUCT LIST - Hover Image Swap
  // ============================
  var productListItems = document.querySelectorAll('.product-list-item');
  productListItems.forEach(function (item) {
    var primaryImg = item.querySelector('.product-list-primary-image');
    var hoverImg = item.querySelector('.product-list-hover-image');

    if (hoverImg && primaryImg) {
      // Position the wrapper relatively for overlay
      var wrapper = primaryImg.closest('.grid-image-wrapper');
      if (wrapper) {
        wrapper.style.position = 'relative';
      }

      // Style hover image: absolutely positioned on top, hidden initially
      hoverImg.style.position = 'absolute';
      hoverImg.style.top = '0';
      hoverImg.style.left = '0';
      hoverImg.style.width = '100%';
      hoverImg.style.height = '100%';
      hoverImg.style.objectFit = 'cover';
      hoverImg.style.opacity = '0';
      hoverImg.style.transition = 'opacity 0.4s ease';
      hoverImg.style.zIndex = '1';

      // Style primary image transition
      primaryImg.style.transition = 'opacity 0.4s ease';

      item.addEventListener('mouseenter', function () {
        hoverImg.style.opacity = '1';
        primaryImg.style.opacity = '0';
      });

      item.addEventListener('mouseleave', function () {
        hoverImg.style.opacity = '0';
        primaryImg.style.opacity = '1';
      });
    } else if (primaryImg) {
      // Fallback: simple hover effect if no second image
      item.addEventListener('mouseenter', function () {
        primaryImg.style.transition = 'transform 0.4s ease, opacity 0.4s ease';
        primaryImg.style.transform = 'scale(1.05)';
        primaryImg.style.opacity = '0.9';
      });

      item.addEventListener('mouseleave', function () {
        primaryImg.style.transform = 'scale(1)';
        primaryImg.style.opacity = '1';
      });
    }
  });

  // ============================
  // PRODUCT DETAIL - Gallery
  // ============================
  const galleryContainer = document.querySelector('[data-product-gallery="container"], .product-gallery');
  if (galleryContainer) {
    const slides = document.querySelectorAll('[data-product-gallery="slides-item"], .product-gallery-slides-item');
    const thumbnails = document.querySelectorAll('[data-product-gallery="thumbnails-item"], .product-gallery-thumbnails-item');
    const prevBtn = document.querySelector('[data-product-gallery="prev"], .product-gallery-prev');
    const nextBtn = document.querySelector('[data-product-gallery="next"], .product-gallery-next');
    const indicator = document.querySelector('[data-product-gallery="indicator"], .product-gallery-current-slide-indicator');

    let currentIndex = 0;
    const total = slides.length;

    function showSlide(index) {
      if (index < 0) index = total - 1;
      if (index >= total) index = 0;
      currentIndex = index;

      slides.forEach(function (slide, i) {
        if (i === index) {
          slide.classList.add('selected');
          slide.classList.remove('prev-slide', 'next-slide');
          slide.removeAttribute('aria-hidden');
          slide.setAttribute('tabindex', '0');
        } else {
          slide.classList.remove('selected');
          slide.classList.add(i < index ? 'prev-slide' : 'next-slide');
          slide.setAttribute('aria-hidden', 'true');
          slide.setAttribute('tabindex', '-1');
        }
      });

      thumbnails.forEach(function (thumb, i) {
        if (i === index) {
          thumb.classList.add('active');
          thumb.setAttribute('aria-current', 'true');
        } else {
          thumb.classList.remove('active');
          thumb.setAttribute('aria-current', 'false');
        }
      });

      if (indicator) {
        indicator.textContent = (index + 1) + ' / ' + total;
      }
    }

    // Thumbnail click
    thumbnails.forEach(function (thumb, i) {
      thumb.addEventListener('click', function (e) {
        e.preventDefault();
        showSlide(i);
      });
    });

    // Prev/Next buttons
    if (prevBtn) {
      prevBtn.addEventListener('click', function (e) {
        e.preventDefault();
        showSlide(currentIndex - 1);
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', function (e) {
        e.preventDefault();
        showSlide(currentIndex + 1);
      });
    }

    // Keyboard navigation
    document.addEventListener('keydown', function (e) {
      if (!galleryContainer.closest('section, .product-detail')) return;
      if (e.key === 'ArrowLeft') {
        showSlide(currentIndex - 1);
      } else if (e.key === 'ArrowRight') {
        showSlide(currentIndex + 1);
      }
    });

    // Touch/swipe support
    let touchStartX = 0;
    let touchEndX = 0;

    galleryContainer.addEventListener('touchstart', function (e) {
      touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    galleryContainer.addEventListener('touchend', function (e) {
      touchEndX = e.changedTouches[0].screenX;
      var diff = touchStartX - touchEndX;
      if (Math.abs(diff) > 50) {
        if (diff > 0) {
          showSlide(currentIndex + 1);
        } else {
          showSlide(currentIndex - 1);
        }
      }
    }, { passive: true });

    // Initialize first slide
    showSlide(0);
  }

  // ============================
  // PRODUCT DETAIL - Lightbox
  // ============================
  const lightbox = document.querySelector('.gallery-lightbox-outer-wrapper, .gallery-lightbox');
  if (lightbox) {
    const lightboxClose = lightbox.querySelector('[data-close], .gallery-lightbox-close-btn');
    const lightboxPrev = lightbox.querySelector('[data-previous], .gallery-lightbox-control-previous') ||
      lightbox.querySelector('[data-previous]');
    const lightboxNext = lightbox.querySelector('[data-next], .gallery-lightbox-control-next') ||
      lightbox.querySelector('[data-next]');
    const lightboxItems = lightbox.querySelectorAll('.gallery-lightbox-item');
    let lightboxIndex = 0;

    function showLightboxSlide(index) {
      if (index < 0) index = lightboxItems.length - 1;
      if (index >= lightboxItems.length) index = 0;
      lightboxIndex = index;

      lightboxItems.forEach(function (item, i) {
        if (i === index) {
          item.style.display = '';
          item.classList.add('active');
        } else {
          item.style.display = 'none';
          item.classList.remove('active');
        }
      });
    }

    // Open lightbox when clicking main gallery image
    var mainSlides = document.querySelectorAll('.product-gallery-slides-item');
    mainSlides.forEach(function (slide) {
      slide.style.cursor = 'pointer';
      slide.addEventListener('click', function () {
        var idx = Array.from(mainSlides).indexOf(slide);
        lightboxIndex = idx;
        showLightboxSlide(idx);
        lightbox.style.display = '';
        lightbox.classList.add('visible');
        document.body.style.overflow = 'hidden';
      });
    });

    if (lightboxClose) {
      lightboxClose.addEventListener('click', function (e) {
        e.preventDefault();
        lightbox.style.display = 'none';
        lightbox.classList.remove('visible');
        document.body.style.overflow = '';
      });
    }

    var lbPrevBtn = lightboxPrev ? lightboxPrev.querySelector('button') : null;
    var lbNextBtn = lightboxNext ? lightboxNext.querySelector('button') : null;

    if (lbPrevBtn) {
      lbPrevBtn.addEventListener('click', function (e) {
        e.preventDefault();
        showLightboxSlide(lightboxIndex - 1);
      });
    }

    if (lbNextBtn) {
      lbNextBtn.addEventListener('click', function (e) {
        e.preventDefault();
        showLightboxSlide(lightboxIndex + 1);
      });
    }

    // Close on escape
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && lightbox.classList.contains('visible')) {
        lightbox.style.display = 'none';
        lightbox.classList.remove('visible');
        document.body.style.overflow = '';
      }
      if (lightbox.classList.contains('visible')) {
        if (e.key === 'ArrowLeft') showLightboxSlide(lightboxIndex - 1);
        if (e.key === 'ArrowRight') showLightboxSlide(lightboxIndex + 1);
      }
    });

    // Initialize: hide lightbox
    lightbox.style.display = 'none';
  }
});