<?php

namespace lib;

class CustomSideBar
{
    private $items;

    public function setItems($items): void
    {
        $this->items = $items;
    }

    public function getItem(): array
    {
        return $this->items;
    }

    public function __construct()
    {
        $this->setItems([]);
    }

    public function addItem($item): void
    {
        $this->items[] = $item;
    }

   

    public function render(): string
    {
        $sidebarItems = '';
        if (!empty($this->items)) {
            foreach ($this->items as $key => $item) {
                $path = $item["path"];
                $label = $item["label"];
                $sidebarItems .= '<a class="text-decoration-none text-dark p-2" href="' . $path . '">' . $label . '</a>';

                // Vérifier si nous ne sommes pas sur le dernier élément du tableau
                if ($key !== array_key_last($this->items)) {
                    $sidebarItems .= '<hr class="sidebar-divider m-0">';
                }
            }
        }
        return <<<HTML
                <div class="offcanvas offcanvas-start" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title d-flex align-items-center gap-1" id="staticBackdropLabel">
                            <span class="material-icons">menu</span>    
                            Menu
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body p-0">
                        <div class="d-flex flex-column " >' . $sidebarItems . '</div>
                    </div>
                </div>
                HTML;
    }
}
