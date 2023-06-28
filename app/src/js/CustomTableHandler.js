import { Modal, Toast } from "bootstrap";

export class CustomTableHandler {
  constructor(formTemplate, apiEndpoint) {
    this.addBtn = document.querySelector("#table-btn-add");
    this.handleAddBtnClick.bind(this)();
    this.apiEndpoint = apiEndpoint;
    this.modalElement = document.createElement("div");
    this.modalElement.classList.add("modal");
    this.formTemplate = formTemplate;
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
    // const modalForm = this.generateModal(title, data);
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

  handleFormSubmit(ev) {
    ev.preventDefault();
    const form = ev.target;
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    const submitButton = form.querySelector(`#${this.buttonSubmitId}`);

    if (submitButton.id === "submit_modal_create") {
      console.log(data);
      this.postData(data).then((resp) => {
        console.log(resp);
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
}
