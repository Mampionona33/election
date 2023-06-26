export class CustomTableHandler {
  constructor(apiEndpoint) {
    this.apiEndpoint = apiEndpoint;
    this.modalAdd = document.querySelector("#formModalAdd");
    this.modalAddButtonAdd = document.querySelector("#addButton");
    this.handleSubmitAdd();
  }

  handleSubmitAdd() {
    if (this.modalAdd) {
      this.modalAdd.addEventListener("submit", async (ev) => {
        ev.preventDefault();

        if (!this.validateForm()) {
          return;
        }
        try {
          const form = ev.target;
          const formData = new FormData(form);
          // console.log(formData);
          const response = await this.postDataToApi(formData);
          // Traiter la réponse de l'API ici
          console.log(response);
        } catch (error) {
          // Gérer les erreurs de l'API ici
          console.error(error);
        }
      });
    }
  }

  async postDataToApi(postData) {
    try {
      const response = await fetch(`/${this.apiEndpoint}`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(Object.fromEntries(postData)),
      });
      const data = await response.json();
      return {
        status: response.status,
        data: data,
      };
    } catch (error) {
      throw error;
    }
  }

  validateForm() {
    const inputFields = document.querySelectorAll("#formModalAdd input");
    for (let i = 0; i < inputFields.length; i++) {
      if (inputFields[i].value.trim() === "") {
        alert("Veuillez remplir tous les champs");
        return false;
      }
    }
    return true;
  }
}
