import "./bootstrap";

import Alpine from "alpinejs";
import Tagify from "@yaireo/tagify";

window.Alpine = Alpine;

Alpine.start();
// resources/js/app.js

document.addEventListener("DOMContentLoaded", function () {
    // تهيئة حقل الوسوم
    const tagInput = document.getElementById("tags");
    if (tagInput) {
        new Tagify(tagInput, {
            delimiters: ",",
            pattern: /^[a-zA-Z0-9\u0600-\u06FF\s]{1,20}$/,
            dropdown: {
                enabled: 1,
                maxItems: 5,
            },
        });
    }

    // فلترة المهام في صفحة العرض
    if (document.getElementById("search-input")) {
        document
            .getElementById("search-input")
            .addEventListener("input", filterTasks);
        document
            .getElementById("status-filter")
            .addEventListener("change", filterTasks);
        document
            .getElementById("tag-filter")
            .addEventListener("change", filterTasks);

        function filterTasks() {
            const search = document
                .getElementById("search-input")
                .value.toLowerCase();
            const status = document.getElementById("status-filter").value;
            const tag = document.getElementById("tag-filter").value;

            document.querySelectorAll(".task-card").forEach((card) => {
                const title = card
                    .querySelector(".text-xl")
                    .textContent.toLowerCase();
                const description = card
                    .querySelector("p")
                    .textContent.toLowerCase();
                const cardStatus = card.dataset.status;
                const cardTags = card.dataset.tags || "";

                const matchesSearch =
                    title.includes(search) || description.includes(search);
                const matchesStatus = status === "all" || cardStatus === status;
                const matchesTag = tag === "all" || cardTags.includes(tag);

                card.style.display =
                    matchesSearch && matchesStatus && matchesTag
                        ? "block"
                        : "none";
            });
        }
    }

    // تأكيد الحذف
    document.querySelectorAll(".confirm-delete").forEach((button) => {
        button.addEventListener("click", function (e) {
            if (!confirm("هل أنت متأكد من رغبتك في حذف هذه المهمة؟")) {
                e.preventDefault();
            }
        });
    });
});
