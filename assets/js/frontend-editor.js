/**
 * FWP Frontend Editor
 * Lightweight inline editing for WordPress
 */
(function() {
    "use strict";

    const FWPEditor = {
        init: function() {
            this.bindEvents();
            this.initInlineEditing();
            this.initSectionControls();
        },

        bindEvents: function() {
            // Save button
            const saveBtn = document.getElementById("fwp-save-all");
            if (saveBtn) {
                saveBtn.addEventListener("click", () => this.saveContent());
            }

            // Section picker close
            const pickerClose = document.querySelector(".fwp-section-picker-close");
            if (pickerClose) {
                pickerClose.addEventListener("click", () => this.closeSectionPicker());
            }

            // Section items
            document.querySelectorAll(".fwp-section-item").forEach(item => {
                item.addEventListener("click", () => this.addSection(item.dataset.section));
            });

            // Close picker on backdrop click
            const picker = document.getElementById("fwp-section-picker");
            if (picker) {
                picker.addEventListener("click", (e) => {
                    if (e.target === picker) this.closeSectionPicker();
                });
            }
        },

        initInlineEditing: function() {
            // Make headings and paragraphs editable
            document.querySelectorAll("[data-fwp-editable]").forEach(el => {
                el.setAttribute("contenteditable", "true");
                el.classList.add("fwp-inline-edit");
            });
        },

        initSectionControls: function() {
            document.querySelectorAll("[data-fwp-section]").forEach(section => {
                const controls = document.createElement("div");
                controls.className = "fwp-section-controls";
                controls.innerHTML = `
                    <button type="button" class="move-up" title="Naar boven"><i class="bi bi-arrow-up"></i></button>
                    <button type="button" class="move-down" title="Naar beneden"><i class="bi bi-arrow-down"></i></button>
                    <button type="button" class="edit" title="Bewerken"><i class="bi bi-pencil"></i></button>
                    <button type="button" class="delete" title="Verwijderen"><i class="bi bi-trash"></i></button>
                `;
                section.appendChild(controls);

                // Button events
                controls.querySelector(".move-up").addEventListener("click", () => this.moveSection(section, "up"));
                controls.querySelector(".move-down").addEventListener("click", () => this.moveSection(section, "down"));
                controls.querySelector(".edit").addEventListener("click", () => this.editSection(section));
                controls.querySelector(".delete").addEventListener("click", () => this.deleteSection(section));
            });
        },

        moveSection: function(section, direction) {
            const parent = section.parentNode;
            if (direction === "up" && section.previousElementSibling) {
                parent.insertBefore(section, section.previousElementSibling);
            } else if (direction === "down" && section.nextElementSibling) {
                parent.insertBefore(section.nextElementSibling, section);
            }
        },

        editSection: function(section) {
            // Open admin edit page for this section
            const type = section.dataset.sectionType || "section";
            alert("Bewerk sectie: " + type + "\nDit opent de sectie editor.");
        },

        deleteSection: function(section) {
            if (confirm("Weet je zeker dat je deze sectie wilt verwijderen?")) {
                section.remove();
            }
        },

        openSectionPicker: function() {
            const picker = document.getElementById("fwp-section-picker");
            if (picker) picker.classList.add("active");
        },

        closeSectionPicker: function() {
            const picker = document.getElementById("fwp-section-picker");
            if (picker) picker.classList.remove("active");
        },

        addSection: function(type) {
            // Generate shortcode placeholder
            const shortcode = `[fwp_${type} title="Nieuwe ${type}"]`;
            console.log("Sectie toegevoegd:", shortcode);
            
            // Insert at cursor or end of content
            const content = document.querySelector(".entry-content, .page-content, article");
            if (content) {
                const placeholder = document.createElement("div");
                placeholder.className = "fwp-new-section";
                placeholder.dataset.fwpSection = type;
                placeholder.dataset.sectionType = type;
                placeholder.innerHTML = `<div class="text-center py-5 bg-light"><p>Nieuwe sectie: ${type}</p><small>Shortcode: ${shortcode}</small></div>`;
                content.appendChild(placeholder);
                this.initSectionControls();
            }
            
            this.closeSectionPicker();
        },

        saveContent: function() {
            const saveBtn = document.getElementById("fwp-save-all");
            const notification = document.getElementById("fwp-save-notification");
            
            if (saveBtn) {
                saveBtn.innerHTML = "<i class=\"bi bi-hourglass\"></i> Opslaan...";
                saveBtn.disabled = true;
            }

            // Collect editable content
            const content = this.collectContent();

            // AJAX save
            const formData = new FormData();
            formData.append("action", "fwp_save_frontend_content");
            formData.append("nonce", fwpEditor.nonce);
            formData.append("post_id", fwpEditor.postId);
            formData.append("content", content);

            fetch(fwpEditor.ajaxUrl, {
                method: "POST",
                body: formData,
                credentials: "same-origin"
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.showNotification("Wijzigingen opgeslagen!", false);
                } else {
                    this.showNotification(data.data.message || "Fout bij opslaan", true);
                }
            })
            .catch(error => {
                console.error("Save error:", error);
                this.showNotification("Fout bij opslaan", true);
            })
            .finally(() => {
                if (saveBtn) {
                    saveBtn.innerHTML = "<i class=\"bi bi-check-lg\"></i> Opslaan";
                    saveBtn.disabled = false;
                }
            });
        },

        collectContent: function() {
            const content = document.querySelector(".entry-content, .page-content");
            return content ? content.innerHTML : "";
        },

        showNotification: function(message, isError) {
            const notification = document.getElementById("fwp-save-notification");
            if (notification) {
                notification.textContent = message;
                notification.classList.toggle("error", isError);
                notification.classList.add("show");
                setTimeout(() => notification.classList.remove("show"), 3000);
            }
        }
    };

    // Initialize on DOM ready
    document.addEventListener("DOMContentLoaded", () => FWPEditor.init());
})();
