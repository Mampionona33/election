import { Modal, Toast } from "bootstrap";

export class CustomTableHandler {
  constructor(formTemplate, apiEndpoint) {
    this.addBtn = document.querySelector("#table-btn-add");
    this.handleAddBtnClick.bind(this)();
    this.apiEndpoint = apiEndpoint;
    this.modalElement = document.createElement("div");
    this.modalElement.classList.add("modal");
    this.formTemplate = formTemplate;
    this.toastElement = document.createElement("div");
    this.removeModal();
    this.removeHiddenToast();
    this.toast;
  }

  handleAddBtnClick() {
    if (this.addBtn) {
      this.addBtn.addEventListener("click", (ev) => {
        ev.preventDefault();
        const modalForm = this.generateModal();
        this.showModal(modalForm);
      });
    }
  }

  showModal(modalForm) {
    if (modalForm) {
      this.modalElement.innerHTML = modalForm;
      document.body.appendChild(this.modalElement);
      this.modal = new Modal(this.modalElement, {
        backdrop: true,
        keyboard: true,
      });
    }

    // Ecouter l'événement de soumission du formulaire
    const form = this.modalElement.querySelector("#form_modal");
    form.addEventListener("submit", this.handleFormSubmit.bind(this));
    this.modal.show();
  }

  removeModal() {
    this.modalElement.addEventListener("hide.bs.modal", () => {
      this.modalElement.remove();
    });
  }

  removeHiddenToast() {
    document.body.addEventListener("hidden.bs.toast", (event) => {
      this.toastElement.remove();
      window.location.reload();
    });
  }

  showToaster(toaster) {
    if (toaster) {
      this.toastElement.innerHTML = toaster;
      document.body.appendChild(this.toastElement);
      this.toast = new Toast(this.toastElement.querySelector(".toast"));
      this.toast.show();
    }
  }

  handleFormSubmit(ev) {
    ev.preventDefault();
    const form = ev.target;
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    const submitButton = form.querySelector(`#${this.buttonSubmitId}`);

    if (submitButton.id === "submit_modal_create") {
      this.postData(data).then((resp) => {
        const title = Object.keys(resp.data)[0];
        const message = Object.values(resp.data)[0];
        if (resp.status == 200) {
          const createdCandidatToast = this.generateToast(title, message);

          this.modal.hide();
          this.showToaster(createdCandidatToast);

          setTimeout(() => {
            this.toast.hide();
          }, 1500);
        }
      });
    }
  }

  async postData(data) {
    try {
      const response = await fetch(`/${this.apiEndpoint}`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data),
      });
      const resp = await response.json();
      return {
        status: response.status,
        data: resp,
      };
    } catch (error) {
      throw error;
    }
  }

  generateModal(title = "Title", data = []) {
    const buttonSubmitText =
      Object.keys(data).length === 0 ? "Ajouter" : "Modifier";

    this.buttonSubmitId =
      Object.keys(data).length === 0
        ? "submit_modal_create"
        : "submit_modal_update";

    return `
        <div class="modal-dialog modal-dialog-centered "> <!-- Ajoutez la classe "modal-lg" pour agrandir la largeur -->
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">${title}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="form_modal">
              <div class="modal-body">
                <div class="d-flex justify-content-center align-items-center">
                  <div class="col-9">${this.formTemplate(data)}</div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="${
                  this.buttonSubmitId
                }" class="btn btn-primary">${buttonSubmitText}</button>
              </div>
            </form>
          </div>
        </div>
      `;
  }

  generateToast(title = "Title", message = "message") {
    return `
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
      <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
          <strong class="me-auto">${title}</strong>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
          ${message}
        </div>
      </div>
    </div>
    `;
  }
}
