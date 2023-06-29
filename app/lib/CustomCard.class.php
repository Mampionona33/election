<?php

namespace lib;

class CustomCard
{
    private $title;
    private $content;
    private $cardBackgroundColor = "#fff";
    private $iconBackgroundColor = "#ddd";
    private $icon;
    private $textColor = "#000";
    private $iconTextColor = "#000";

    public function __construct()
    {
    }

    public function setIcon($icon): void
    {
        $this->icon = $icon;
    }

    public function setContent($content): void
    {
        $this->content = $content;
    }

    public function setBackgroundColor($cardBackgroundColor): void
    {
        $this->cardBackgroundColor = $cardBackgroundColor;
    }

    public function setIconBackgroundColor($iconBackgroundColor): void
    {
        $this->iconBackgroundColor = $iconBackgroundColor;
    }

    public function setTextColor($textColor): void
    {
        $this->textColor = $textColor;
    }

    public function setIconTextColor($iconTextColor): void
    {
        $this->iconTextColor = $iconTextColor;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }


    private function renderIcon(): mixed
    {
        $iconBackgroundColor = $this->iconBackgroundColor;
        $iconTextColor = $this->iconTextColor;
        if (isset($this->icon)) {
            return <<<HTML
            <span class="material-icons-outlined rounded-circle p-1 m-2" style="background-color:$iconBackgroundColor; color:$iconTextColor; font-size:2.5rem;">
                $this->icon
            </span>
            HTML;
        }
        return null;
    }

    public function __invoke(): string
    {
        $cardTitle = $this->title;
        $content = $this->content;
        $cardBackgroundColor = $this->cardBackgroundColor;
        $textColor = $this->textColor;
        $icon = $this->renderIcon();

        $iconHtml = '';
        if ($icon !== null) {
            $iconHtml = $icon;
        }

        return <<<HTML
        <div class="global-data-card m-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body" style="background-color: $cardBackgroundColor; color: $textColor;">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title text-capitalize flex-grow-1">$cardTitle</h5>
                        $iconHtml
                    </div>
                    <hr class="hr" >
                    <h6 class="d-flex card-subtitle mb-2 mt-2" style="color: $textColor;">$content</h6>
                </div>
            </div>
        </div>
        HTML;
    }
}
