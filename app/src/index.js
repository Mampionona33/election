import { CustomTableHandler } from "./js/CustomTableHandler";
import "./styles/style.scss";
import * as bootstrap from "bootstrap";
console.log("Hello World!");

const generateCandidatForm = (data) => {
  return `
    <div class="form-group row">
      <label for="name" class="col-sm-6 col-form-label">Nom</label> <!-- Ajustez la classe "col-sm-4" pour agrandir la largeur du label -->
      <div class="col-sm-6">
          <input type="text" class="form-control form-control-sm" name="name" id="name" value="${
            data["name"] ? data["name"] : ""
          }" required>
      </div>
    </div>
    <div class="form-group row">
      <label for="nbVoix" class="col-sm-6 col-form-label">Nombre de voix</label>
      <div class="col-sm-6">
          <input type="number" class="form-control form-control-sm" name="nbVoix" id="nbVoix" value="${
            data["nbVoix"] ? data["nbVoix"] : ""
          }" required>
      </div>
    </div>`;
};

window.addEventListener("load", () => {
  const candidatTableHandler = new CustomTableHandler(
    generateCandidatForm,
    "api/entry"
  );
});
