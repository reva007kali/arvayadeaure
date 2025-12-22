class ScrollAnimator {
    constructor(options = {}) {
        this.options = {
            root: null,
            rootMargin: options.offset || "0px 0px -50px 0px",
            threshold: options.threshold || 0.1,
            once: options.once !== undefined ? options.once : true,
        };

        this.init();
    }

    init() {
        if (!("IntersectionObserver" in window)) {
            this.showAll();
            return;
        }

        this.observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    this.animateIn(entry.target);
                    if (this.options.once)
                        this.observer.unobserve(entry.target);
                } else {
                    if (!this.options.once) this.animateOut(entry.target);
                }
            });
        }, this.options);

        this.scanElements();
    }

    scanElements() {
        // 1. JALANKAN LOGIKA STAGGER DULUAN
        // Cari semua container yang punya atribut data-anim-stagger
        const staggerContainers = document.querySelectorAll(
            "[data-anim-stagger]"
        );

        staggerContainers.forEach((container) => {
            // Ambil waktu jeda (default 0.1 detik jika kosong)
            const staggerTime =
                parseFloat(container.getAttribute("data-anim-stagger")) || 0.1;
            // Cari anak-anak di dalamnya yang punya data-anim
            const children = container.querySelectorAll("[data-anim]");

            children.forEach((child, index) => {
                // Cek apakah anak ini punya delay manual sendiri?
                const baseDelay =
                    parseFloat(child.getAttribute("data-delay")) || 0;

                // Rumus: Delay Manual + (Urutan * Waktu Jeda)
                const finalDelay = baseDelay + index * staggerTime;

                // Set variabel CSS langsung ke elemen anak
                child.style.setProperty("--anim-delay", `${finalDelay}s`);
            });
        });

        // 2. SETELAH DELAY DIHITUNG, BARU MULAI OBSERVE SEPERTI BIASA
        const elements = document.querySelectorAll("[data-anim]");
        elements.forEach((el) => {
            const duration = el.getAttribute("data-duration");
            const ease = el.getAttribute("data-ease");

            // (Note: Delay sudah diurus oleh logika stagger di atas,
            // tapi jika bukan stagger, kita baca manual di sini)
            if (!el.style.getPropertyValue("--anim-delay")) {
                const delay = el.getAttribute("data-delay");
                if (delay) el.style.setProperty("--anim-delay", delay);
            }

            if (duration) el.style.setProperty("--anim-duration", duration);
            if (ease) el.style.setProperty("--anim-ease", ease);

            this.observer.observe(el);
        });
    }

    animateIn(element) {
        element.classList.add("is-visible");
    }

    animateOut(element) {
        element.classList.remove("is-visible");
    }

    showAll() {
        document.querySelectorAll("[data-anim]").forEach((el) => {
            el.classList.add("is-visible");
        });
    }
}

// Init
document.addEventListener("DOMContentLoaded", () => {
    new ScrollAnimator({
        once: true,
        offset: "0px 0px -50px 0px",
    });

    // PWA install prompt handling
    let deferredPrompt = null;
    const btn = document.getElementById("pwa-install-btn");

    window.addEventListener("beforeinstallprompt", (e) => {
        e.preventDefault();
        deferredPrompt = e;
        if (btn) btn.style.display = "inline-flex";
    });

    if (btn) {
        btn.addEventListener("click", async () => {
            if (!deferredPrompt) return;
            deferredPrompt.prompt();
            const { outcome } = await deferredPrompt.userChoice;
            deferredPrompt = null;
            btn.style.display = "none";
            console.log("PWA install", outcome);
        });
    }

    window.addEventListener("appinstalled", () => {
        if (btn) btn.style.display = "none";
        console.log("PWA installed");
    });
});

document.addEventListener("alpine:init", () => {
    Alpine.data("youtubePlayer", (url) => ({
        player: null,
        isPlaying: false,
        isOpen: false,
        videoId: "",
        initPlayer() {
            const match = url.match(
                /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/
            );
            this.videoId = match && match[2].length === 11 ? match[2] : null;
            if (!this.videoId) return;
            if (!window.YT) {
                const tag = document.createElement("script");
                tag.src = "https://www.youtube.com/iframe_api";
                document.body.appendChild(tag);
                window.onYouTubeIframeAPIReady = () => this.createPlayer();
            } else {
                this.createPlayer();
            }
        },
        createPlayer() {
            this.player = new YT.Player("yt-player-container", {
                height: "100%",
                width: "100%",
                videoId: this.videoId,
                playerVars: {
                    autoplay: 1,
                    playsinline: 1,
                    controls: 0,
                    loop: 1,
                    playlist: this.videoId,
                },
                events: {
                    onReady: (e) => {
                        e.target.setPlaybackQuality("tiny");
                        e.target.playVideo();
                    },
                    onStateChange: (e) => {
                        this.isPlaying = e.data === YT.PlayerState.PLAYING;
                    },
                },
            });
        },
        playMusic() {
            if (this.player && this.player.playVideo) {
                this.player.playVideo();
                this.isPlaying = true;
            }
        },
        togglePlay() {
            if (!this.player) return;
            this.isPlaying ? this.player.pauseVideo() : this.player.playVideo();
        },
        seek(s) {
            if (!this.player) return;
            this.player.seekTo(this.player.getCurrentTime() + s, true);
        },
    }));
});
