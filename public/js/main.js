document.addEventListener('DOMContentLoaded', () => {
    // ==========================
    // 1. Navbar & UI Interactions
    // ==========================
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        const navbarCollapse = document.getElementById('navbarNav');
        if (navbarCollapse) {
            navbarCollapse.addEventListener('show.bs.collapse', function () {
                navbar.classList.add('menu-open');
            });

            navbarCollapse.addEventListener('hide.bs.collapse', function () {
                navbar.classList.remove('menu-open');
            });
        }
    }


    // ==========================
    // 2. Scroll Reveal Animation
    // ==========================
    const revealElements = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');
    if (revealElements.length > 0) {
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.15,
            rootMargin: '0px 0px -50px 0px'
        });
        revealElements.forEach(el => revealObserver.observe(el));
    }

    // ==========================
    // 3. Hero Slideshow
    // ==========================
    const heroSlides = document.querySelectorAll('.hero-slide');
    if (heroSlides.length > 0) {
        let currentSlide = 0;
        const slideInterval = 5000;

        function nextSlide() {
            heroSlides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % heroSlides.length;
            heroSlides[currentSlide].classList.add('active');
        }
        setInterval(nextSlide, slideInterval);
    }

    // ==========================
    // 4. Book Now Modal
    // ==========================
    const bookBtn = document.getElementById('bookNowBtn');
    const bookModal = document.getElementById('bookModal');
    const bookModalClose = document.getElementById('bookModalClose');

    if (bookBtn && bookModal && bookModalClose) {
        bookBtn.addEventListener('click', function (e) {
            e.preventDefault();
            bookModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        });

        bookModalClose.addEventListener('click', function () {
            bookModal.classList.remove('active');
            document.body.style.overflow = '';
        });

        bookModal.addEventListener('click', function (e) {
            if (e.target === bookModal) {
                bookModal.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    }

    // ==========================
    // 6. Home Page Gallery Slider
    // ==========================
    const galleryWrapper = document.querySelector('.gallery-slider-wrapper');
    const galleryTrack = document.querySelector('.gallery-track');

    if (galleryWrapper && galleryTrack) {
        let isDragging = false;
        let startX, dragStartPos;
        let currentPos = 0;
        let isAutoScrolling = true;
        const SPEED_PX_PER_SEC = 64;
        let lastTime = performance.now();
        let rafId;

        function getSetWidth() {
            return galleryTrack.scrollWidth / 2;
        }

        function loop(now) {
            if (isAutoScrolling && !isDragging) {
                const dt = (now - lastTime) / 1000;
                currentPos -= SPEED_PX_PER_SEC * dt;

                const setWidth = getSetWidth();
                while (currentPos <= -setWidth) currentPos += setWidth;
                while (currentPos > 0) currentPos -= setWidth;

                galleryTrack.style.transform = `translateX(${currentPos}px)`;
            }
            lastTime = now;
            rafId = requestAnimationFrame(loop);
        }

        rafId = requestAnimationFrame(loop);

        galleryWrapper.addEventListener('mousedown', (e) => {
            isDragging = true;
            isAutoScrolling = false;
            galleryWrapper.style.cursor = 'grabbing';
            startX = e.pageX;
            dragStartPos = currentPos;
        });

        galleryWrapper.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            e.preventDefault();
            currentPos = dragStartPos + (e.pageX - startX);
            galleryTrack.style.transform = `translateX(${currentPos}px)`;
        });

        function endDrag() {
            if (!isDragging) return;
            isDragging = false;
            galleryWrapper.style.cursor = 'grab';

            const setWidth = getSetWidth();
            while (currentPos <= -setWidth) currentPos += setWidth;
            while (currentPos > 0) currentPos -= setWidth;
            galleryTrack.style.transform = `translateX(${currentPos}px)`;

            isAutoScrolling = true;
        }

        galleryWrapper.addEventListener('mouseup', endDrag);
        galleryWrapper.addEventListener('mouseleave', endDrag);

        galleryWrapper.addEventListener('touchstart', (e) => {
            isDragging = true;
            isAutoScrolling = false;
            startX = e.touches[0].pageX;
            dragStartPos = currentPos;
        }, { passive: true });

        galleryWrapper.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            currentPos = dragStartPos + (e.touches[0].pageX - startX);
            galleryTrack.style.transform = `translateX(${currentPos}px)`;
        }, { passive: true });

        galleryWrapper.addEventListener('touchend', endDrag);
        galleryWrapper.addEventListener('touchcancel', endDrag);
    }

    // ==========================
    // 7. Home Page Testimonial Slider
    // ==========================
    const testimonialWrapper = document.querySelector('.testimonial-slider-wrapper');
    const testimonialTrack = document.querySelector('.testimonial-track');

    if (testimonialWrapper && testimonialTrack) {
        let isDragging = false;
        let startX, dragStartPos;
        let currentPos = 0;
        let lastTime = performance.now();
        let rafId;
        const SPEED_PX_PER_SEC = 42;
        let isPaused = false;

        function getSetWidth() {
            return testimonialTrack.scrollWidth / 2;
        }

        function loop(now) {
            if (!isDragging && !isPaused) {
                const dt = (now - lastTime) / 1000;
                currentPos -= SPEED_PX_PER_SEC * dt;

                const setWidth = getSetWidth();
                while (currentPos <= -setWidth) currentPos += setWidth;
                while (currentPos > 0) currentPos -= setWidth;

                testimonialTrack.style.transform = `translateX(${currentPos}px)`;
            }
            lastTime = now;
            rafId = requestAnimationFrame(loop);
        }

        rafId = requestAnimationFrame(loop);

        testimonialWrapper.addEventListener('mouseenter', () => {
            isPaused = false;
        });

        testimonialWrapper.addEventListener('mouseleave', () => {
            isPaused = false;
            lastTime = performance.now();
        });

        testimonialWrapper.addEventListener('mousedown', (e) => {
            isDragging = true;
            testimonialWrapper.style.cursor = 'grabbing';
            startX = e.pageX;
            dragStartPos = currentPos;
        });

        testimonialWrapper.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            e.preventDefault();
            currentPos = dragStartPos + (e.pageX - startX);
            testimonialTrack.style.transform = `translateX(${currentPos}px)`;
        });

        function endDrag() {
            if (!isDragging) return;
            isDragging = false;
            testimonialWrapper.style.cursor = 'grab';

            const setWidth = getSetWidth();
            while (currentPos <= -setWidth) currentPos += setWidth;
            while (currentPos > 0) currentPos -= setWidth;
            testimonialTrack.style.transform = `translateX(${currentPos}px)`;
        }

        testimonialWrapper.addEventListener('mouseup', endDrag);
        testimonialWrapper.addEventListener('mouseleave', () => {
            isPaused = false;
            endDrag();
        });

        testimonialWrapper.addEventListener('touchstart', (e) => {
            isDragging = true;
            startX = e.touches[0].pageX;
            dragStartPos = currentPos;
        }, { passive: true });

        testimonialWrapper.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            currentPos = dragStartPos + (e.touches[0].pageX - startX);
            testimonialTrack.style.transform = `translateX(${currentPos}px)`;
        }, { passive: true });

        testimonialWrapper.addEventListener('touchend', endDrag);
        testimonialWrapper.addEventListener('touchcancel', endDrag);
    }

    // ==========================
    // 8. Video Modal
    // ==========================
    const videoModal = document.getElementById('videoModal');
    const popupVideo = document.getElementById('popupVideo');

    if (videoModal && popupVideo) {
        videoModal.addEventListener('shown.bs.modal', function () {
            popupVideo.play();
        });

        videoModal.addEventListener('hidden.bs.modal', function () {
            popupVideo.pause();
            popupVideo.currentTime = 0;
        });
    }

    // ==========================
    // 11. Accordion Logic
    // ==========================
    const accordionHeaders = document.querySelectorAll('.accordion-header');

    if (accordionHeaders.length > 0) {
        accordionHeaders.forEach(header => {
            header.addEventListener('click', function () {
                const item = this.parentElement;
                const allItems = document.querySelectorAll('.accordion-item');
                const toggleIcon = this.querySelector('.accordion-toggle');

                allItems.forEach(acc => {
                    if (acc !== item) {
                        acc.classList.remove('active');
                        const otherToggle = acc.querySelector('.accordion-toggle');
                        if (otherToggle) otherToggle.innerHTML = '+';
                    }
                });

                if (item.classList.contains('active')) {
                    item.classList.remove('active');
                    if (toggleIcon) toggleIcon.innerHTML = '+';
                } else {
                    item.classList.add('active');
                    if (toggleIcon) toggleIcon.innerHTML = '&minus;';
                }
            });
        });
    }

    // ==========================
    // 12. Mega Menu Resort Preview
    // ==========================
    const megaItems = document.querySelectorAll(".mega-resort-list a");
    const megaImage = document.getElementById("megaImage");
    const megaTitle = document.getElementById("megaTitle");
    const megaSubtitle = document.getElementById("megaSubtitle");
    const megaDescription = document.getElementById("megaDescription");

    if (megaItems.length && megaImage && megaTitle && megaSubtitle && megaDescription) {
        megaItems.forEach(item => {
            item.addEventListener("mouseenter", function () {
                megaItems.forEach(link => link.classList.remove("active"));
                this.classList.add("active");

                megaImage.src = this.dataset.image || "";
                megaTitle.innerHTML = this.dataset.title || "";
                megaSubtitle.innerHTML = this.dataset.subtitle || "";
                megaDescription.innerHTML = this.dataset.description || "";
            });
        });
    }

    const megaTrigger = document.getElementById("megaTrigger");
    if (megaTrigger) {
        megaTrigger.addEventListener("click", function (e) {
            if (window.innerWidth <= 991) {
                e.preventDefault();
                this.parentElement.classList.toggle("show");
            }
        });
    }

    const megaDropdown = document.querySelector(".mega-dropdown");
    if (megaDropdown) {
        window.addEventListener("scroll", () => {
            megaDropdown.classList.add("hide-mega");
            clearTimeout(window.scrollTimer);
            window.scrollTimer = setTimeout(() => {
                megaDropdown.classList.remove("hide-mega");
            }, 150);
        });
    }

    // ==========================
    // 13. Smooth Scrolling (Lenis)
    // ==========================
    if (typeof Lenis !== 'undefined') {
        const lenis = new Lenis({
            duration: 1.2,
            smoothWheel: true,
            wheelMultiplier: 0.9,
            touchMultiplier: 1.5,
            infinite: false
        });
        window.lenis = lenis;

        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }
        requestAnimationFrame(raf);

        // Prevent background page scrolling via Lenis when Bootstrap modals are open
        document.addEventListener('show.bs.modal', () => {
            lenis.stop();
        });
        document.addEventListener('hidden.bs.modal', () => {
            // Only restart Lenis if no other modals are currently open
            if (document.querySelectorAll('.modal.show').length === 0) {
                lenis.start();
            }
        });
    }

    // ==========================
    // 14. Resort Pinned Scroll & Tab Navigation (GSAP)
    // ==========================
    if (typeof gsap !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

        const pinnedSection = document.getElementById("pinnedSection");
        const navButtons = document.querySelectorAll(".tab-nav-btn");
        const resortItems = document.querySelectorAll(".resort-item");
        const resortTrack = document.getElementById("resortTrack");
        const resortWindow = document.getElementById("resortWindow");

        if (pinnedSection && resortTrack && resortItems.length > 0) {
            const totalItems = resortItems.length;
            let currentResortIndex = -1;
            let scrollTriggerInstance = null;
            let mobileObserver = null;

            function updateActiveResort(index) {
                if (index === currentResortIndex) return;

                navButtons.forEach((btn, idx) => {
                    btn.classList.toggle("active", idx === index);
                    if (idx === index && window.innerWidth < 992) {
                        const navContainer = document.getElementById("tabNav");
                        if (navContainer) {
                            const btnOffsetLeft = btn.offsetLeft;
                            const containerPadding = parseFloat(getComputedStyle(navContainer).paddingLeft) || 0;
                            navContainer.scrollTo({
                                left: btnOffsetLeft - containerPadding,
                                behavior: 'smooth'
                            });
                        }
                    }
                });

                resortItems.forEach((item, idx) => {
                    item.classList.toggle("active", idx === index);
                });

                currentResortIndex = index;
            }

            function getItemCenterOffsetY(index) {
                const targetItem = resortItems[index];
                if (!targetItem) return 0;
                return -(targetItem.offsetTop + (targetItem.offsetHeight / 2));
            }

            function initDesktopPinnedScroll() {
                gsap.set(resortTrack, { y: getItemCenterOffsetY(0) });

                const screenWidth = window.innerWidth;

                // Small Laptops & Mid-screens (991px to 1440px)-il snap disable aakkunnu
                const enableSnap = screenWidth > 1440;

                // 991px to 1440px nidayil fast scroll kittan Multiplier kuraykkunnu (e.g., 0.4 instead of 0.5/1)
                // Smaller multiplier = Faster scroll speed
                let scrollDistanceMultiplier = 0.5;
                if (screenWidth >= 991 && screenWidth <= 1440) {
                    scrollDistanceMultiplier = 0.2; // Speed kootan vendi multiplier kurachu
                }

                scrollTriggerInstance = ScrollTrigger.create({
                    trigger: pinnedSection,
                    start: "top top",
                    end: () => `+=${window.innerHeight * (totalItems - scrollDistanceMultiplier)}`,
                    pin: true,
                    scrub: 0.3, // Scrub responsiveness kootan duration 0.6-il ninnu 0.3 aakki
                    snap: enableSnap ? {
                        snapTo: 1 / (totalItems - 1),
                        duration: { min: 0.25, max: 0.5 },
                        delay: 0.05,
                        ease: "power2.inOut"
                    } : false,
                    onUpdate: (self) => {
                        const progress = self.progress;
                        const rawIndex = progress * (totalItems - 1);
                        const activeIndex = Math.min(Math.round(rawIndex), totalItems - 1);

                        updateActiveResort(activeIndex);

                        const firstOffset = getItemCenterOffsetY(0);
                        const lastOffset = getItemCenterOffsetY(totalItems - 1);
                        const currentOffset = gsap.utils.interpolate(firstOffset, lastOffset, progress);

                        gsap.to(resortTrack, {
                            y: currentOffset,
                            duration: 0.1,
                            overwrite: "auto",
                            ease: "none"
                        });
                    }
                });
            }

            function initMobileSwipe() {
                if (!resortWindow) return;
                mobileObserver = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            const activeIndex = parseInt(entry.target.getAttribute("data-index"));
                            if (!isNaN(activeIndex)) updateActiveResort(activeIndex);
                        }
                    });
                }, { root: resortWindow, threshold: 0.6 });

                resortItems.forEach((item) => mobileObserver.observe(item));
            }

            navButtons.forEach((btn) => {
                btn.addEventListener("click", (e) => {
                    const targetIndex = parseInt(e.currentTarget.getAttribute("data-index"));
                    if (isNaN(targetIndex)) return;

                    if (window.innerWidth >= 992 && scrollTriggerInstance) {
                        const totalScrollDistance = scrollTriggerInstance.end - scrollTriggerInstance.start;
                        const targetScrollPos = scrollTriggerInstance.start + (totalScrollDistance * (targetIndex / (totalItems - 1)));
                        gsap.to(window, { scrollTo: targetScrollPos, duration: 0.5, ease: "power2.out" });
                    } else if (resortWindow) {
                        const targetSlide = resortItems[targetIndex];
                        if (targetSlide) {
                            resortWindow.scrollTo({ left: targetSlide.offsetLeft, behavior: "smooth" });
                        }
                    }
                });
            });

            function handleBreakpoint() {
                if (window.innerWidth >= 992) {
                    if (mobileObserver) { mobileObserver.disconnect(); mobileObserver = null; }

                    if (scrollTriggerInstance) {
                        scrollTriggerInstance.kill();
                        scrollTriggerInstance = null;
                    }
                    initDesktopPinnedScroll();
                } else {
                    if (scrollTriggerInstance) {
                        scrollTriggerInstance.kill();
                        scrollTriggerInstance = null;
                        gsap.set(resortTrack, { clearProps: "all" });
                    }
                    if (!mobileObserver) initMobileSwipe();
                }
            }

            handleBreakpoint();

            let resizeTimer;
            window.addEventListener("resize", () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    handleBreakpoint();
                    if (window.innerWidth >= 992) {
                        gsap.set(resortTrack, { y: getItemCenterOffsetY(currentResortIndex < 0 ? 0 : currentResortIndex) });
                    }
                }, 100);
            });
        }
    }
});