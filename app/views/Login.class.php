<?php

namespace views;

use template\TemplateRenderer;

class Login
{
    private $templateRenderer;

    public function __construct()
    {
        $this->templateRenderer = new TemplateRenderer();
    }

    private function loginForm(): string
    {
        return <<<HTML
        <div class="d-flex w-100 justify-content-center align-items-center" style="height: 100vh;">
            <div class="">
                <form method="POST" class="d-flex flex-column gap-2 bg-white rounded shadow p-4">
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">Identifiant</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control form-control-sm" name="email" id="email" placeholder="exemple@email.com" autocomplete="exemple@email.com" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control form-control-sm" name="password" id="password" autocomplete="current-password" >
                        </div>
                    </div>
                    <div class="d-flex justify-content-start align-items-center gap-3 btn btn-primary">
                        <span class="material-icons-outlined">
                            vpn_key
                        </span>
                        <div class="d-flex justify-content-center w-100">
                            <input type="submit" value="Login" class="btn text-white" style="font-size: 1.2rem;">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        HTML;
    }

    public function render(): string
    {
        $this->templateRenderer->setBodyContent($this->loginForm());
        return $this->templateRenderer->render("Login Page");
    }
}
