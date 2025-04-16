<html>
  <head>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link
      rel="stylesheet"
      as="style"
      onload="this.rel='stylesheet'"
      href="https://fonts.googleapis.com/css2?display=swap&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900&amp;family=Plus+Jakarta+Sans%3Awght%40400%3B500%3B700%3B800"
    />

    <title>Recap</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  </head>
  <body>
    <div
      class="relative flex size-full min-h-screen flex-col bg-[#1A1A1A] dark group/design-root overflow-x-hidden"
      style='font-family: "Plus Jakarta Sans", "Noto Sans", sans-serif;'
    >
      <div class="layout-container flex h-full grow flex-col">
        <body>
          <div
            class="relative flex size-full min-h-screen flex-col bg-[#1A1A1A] dark group/design-root overflow-x-hidden"
            style='font-family: "Plus Jakarta Sans", "Noto Sans", sans-serif;'
          >
            <div class="layout-container flex h-full grow flex-col">
              <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#2E2E2E] px-10 py-3">
                <div class="flex items-center gap-4 text-[#FFFFFF]">
                  <div class="size-4">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M36.7273 44C33.9891 44 31.6043 39.8386 30.3636 33.69C29.123 39.8386 26.7382 44 24 44C21.2618 44 18.877 39.8386 17.6364 33.69C16.3957 39.8386 14.0109 44 11.2727 44C7.25611 44 4 35.0457 4 24C4 12.9543 7.25611 4 11.2727 4C14.0109 4 16.3957 8.16144 17.6364 14.31C18.877 8.16144 21.2618 4 24 4C26.7382 4 29.123 8.16144 30.3636 14.31C31.6043 8.16144 33.9891 4 36.7273 4C40.7439 4 44 12.9543 44 24C44 35.0457 40.7439 44 36.7273 44Z"
                        fill="currentColor"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#FFFFFF] text-lg font-bold leading-tight tracking-[-0.015em]">VROUMMM Prestige</h2>
                </div>
                <div class="flex flex-1 justify-end gap-8">
                  <div class="flex items-center gap-9">
                    <a class="text-[#FFFFFF] text-sm font-medium leading-normal" href="index.html">Accueil</a>
                    <a class="text-[#FFFFFF] text-sm font-medium leading-normal" href="search.html">Catalogue</a>
                    <a class="text-[#FFFFFF] text-sm font-medium leading-normal" href="#">À propos</a>
                    <a class="text-[#FFFFFF] text-sm font-medium leading-normal" href="contact.html">Contact</a>
                    <button
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-10 px-4 bg-[#019863] text-[#FFFFFF] text-sm font-bold leading-normal tracking-[0.015em]"
                onclick="window.location.href='login_register.html'">
                <span class="truncate">Se Connecter / S'inscrire</span>
              </button>
                  </div>
                </div>
              </header>
        <div class="px-40 flex flex-1 justify-center py-5">
          <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
            <div class="p-4 @container">
              <div class="flex flex-col items-stretch justify-start rounded-xl @xl:flex-row @xl:items-start shadow-[0_0_4px_rgba(0,0,0,0.1)] bg-[#242424]">
                <div
                  class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-xl"
                  style='background-image: url("https://img4.autodeclics.com/photo_article/69124/4410/1200-L-essai-bmw-330d.jpg");'
                ></div>
                <div class="flex w-full min-w-72 grow flex-col items-stretch justify-center gap-1 py-4 @xl:px-4 px-4">
                  <p class="text-[#FFFFFF] text-lg font-bold leading-tight tracking-[-0.015em]">Récapitulatif de la Réservation</p>
                  <div class="flex items-end gap-3 justify-between">
                    <div class="flex flex-col gap-1">
                      <p class="text-[#999999] text-base font-normal leading-normal">Modèle sélectionné: BMW 330D</p>
                      <p class="text-[#999999] text-base font-normal leading-normal">Veuillez vérifier vos informations avant de procéder à la location : </p>
                      <p class="text-[#999999] text-base font-normal leading-normal">Marque : BMW</p>
                      <p class="text-[#999999] text-base font-normal leading-normal">Modèle : 330d</p>
                      <p class="text-[#999999] text-base font-normal leading-normal">Année : 2008</p>
                      <p class="text-[#999999] text-base font-normal leading-normal">Type : Berline</p>
                      <p class="text-[#999999] text-base font-normal leading-normal">Carburant : Diesel</p>
                      <p class="text-[#999999] text-base font-normal leading-normal">Nb de Porte : 5</p>

                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="p-4 grid grid-cols-[20%_1fr] gap-x-6">
              <div class="col-span-2 grid grid-cols-subgrid border-t border-t-[#3D3D3D] py-5">
                <p class="text-[#999999] text-sm font-normal leading-normal">Nom</p>
                <p class="text-[#FFFFFF] text-sm font-normal leading-normal">Doe</p>
              </div>
              <div class="col-span-2 grid grid-cols-subgrid border-t border-t-[#3D3D3D] py-5">
                <p class="text-[#999999] text-sm font-normal leading-normal">Prénom</p>
                <p class="text-[#FFFFFF] text-sm font-normal leading-normal">John</p>
              </div>
              <div class="col-span-2 grid grid-cols-subgrid border-t border-t-[#3D3D3D] py-5">
                <p class="text-[#999999] text-sm font-normal leading-normal">Email</p>
                <p class="text-[#FFFFFF] text-sm font-normal leading-normal">john.doe@example.com</p>
              </div>
              <div class="col-span-2 grid grid-cols-subgrid border-t border-t-[#3D3D3D] py-5">
                <p class="text-[#999999] text-sm font-normal leading-normal">Num tel</p>
                <p class="text-[#FFFFFF] text-sm font-normal leading-normal">0123456789</p>
              </div>
              <div class="col-span-2 grid grid-cols-subgrid border-t border-t-[#3D3D3D] py-5">
                <p class="text-[#999999] text-sm font-normal leading-normal">Date</p>
                <p class="text-[#FFFFFF] text-sm font-normal leading-normal">De 05/09/2024 au 11/09/2024</p>
              </div>
              <div class="col-span-2 grid grid-cols-subgrid border-t border-t-[#3D3D3D] py-5">
                <p class="text-[#999999] text-sm font-normal leading-normal">Prix</p>
                <p class="text-[#FFFFFF] text-sm font-normal leading-normal">1 500€</p>
              </div>
            </div>
          </div>
        </div>
        <footer class="flex justify-center">
          <div class="flex max-w-[960px] flex-1 flex-col">
            <div class="flex px-4 py-3 justify-center">
              <button
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-12 px-5 flex-1 bg-[#019863] text-[#FFFFFF] text-base font-bold leading-normal tracking-[0.015em]"
              >
                <span class="truncate">Louer</span>
              </button>
            </div>
          </div>
        </footer>
      </div>
    </div>
  </body>
</html>
