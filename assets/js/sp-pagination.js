(function () {
  document.addEventListener("DOMContentLoaded", function () {

    class SP_Pagination {
      constructor(el) {
        this.el = el;

        this.target = el.dataset.target;
        this.selector = el.dataset.itemSelector;
        this.perPage = parseInt(el.dataset.itemsPerPage) || 6;

        this.editable = el.dataset.editable === "true";
        this.showFirstLast = el.dataset.firstLast === "true";

        this.container = this.findContainer();
        if (!this.container) {
          console.warn("Smart Pagination: container not found");
          return;
        }

        this.items = Array.from(
          this.container.querySelectorAll(this.selector)
        );

        this.current = 1;

        this.curEl = el.querySelector(".current-page");
        this.totalEl = el.querySelector(".total-pages");

        // hide first/last if disabled
        if (!this.showFirstLast) {
          const firstBtn = el.querySelector(".first");
          const lastBtn = el.querySelector(".last");
          if (firstBtn) firstBtn.remove();
          if (lastBtn) lastBtn.remove();
        }

        this.init();
        this.update();
      }

      // 🔍 auto-detect container
      findContainer() {
        let prev = this.el.previousElementSibling;
        if (prev && prev.matches(this.target)) {
          return prev;
        }

        return document.querySelector(this.target);
      }

      init() {
        // next
        const nextBtn = this.el.querySelector(".next");
        if (nextBtn) {
          nextBtn.onclick = () => {
            if (this.current < this.total) {
              this.current++;
              this.update();
            }
          };
        }

        // prev
        const prevBtn = this.el.querySelector(".prev");
        if (prevBtn) {
          prevBtn.onclick = () => {
            if (this.current > 1) {
              this.current--;
              this.update();
            }
          };
        }

        // first
        const firstBtn = this.el.querySelector(".first");
        if (firstBtn) {
          firstBtn.onclick = () => {
            this.current = 1;
            this.update();
          };
        }

        // last
        const lastBtn = this.el.querySelector(".last");
        if (lastBtn) {
          lastBtn.onclick = () => {
            this.current = this.total;
            this.update();
          };
        }

        // editable page
        if (this.editable && this.curEl) {
          this.curEl.setAttribute("contenteditable", "true");

          this.curEl.addEventListener("keydown", (e) => {
            if (e.key === "Enter") {
              e.preventDefault();

              let value = parseInt(this.curEl.textContent.trim());

              if (!isNaN(value)) {
                if (value < 1) value = 1;
                if (value > this.total) value = this.total;

                this.current = value;
                this.update();
              }

              this.curEl.blur();
            }
          });

          this.curEl.addEventListener("blur", () => {
            this.curEl.textContent = this.current;
          });
        }
      }

      update() {
        this.total = Math.ceil(this.items.length / this.perPage) || 1;

        if (this.current < 1) this.current = 1;
        if (this.current > this.total) this.current = this.total;

        if (this.curEl) this.curEl.textContent = this.current;
        if (this.totalEl) this.totalEl.textContent = this.total;

        this.items.forEach((item, index) => {
          if (
            index >= (this.current - 1) * this.perPage &&
            index < this.current * this.perPage
          ) {
            item.style.display = "block";
          } else {
            item.style.display = "none";
          }
        });
      }
    }

    // init all paginations
    const paginations = document.querySelectorAll(".sp-pagination");
    paginations.forEach((el) => {
      new SP_Pagination(el);
    });

  });
})();