const addImage = document.querySelector('#add-image')

    addImage.addEventListener('click', () => {
        console.log('o')
        // compter combien j'ai de form-group pour les indices ex : annonce_image_0_url
        const widgetCounter = document.querySelector("#counter-w")
        const index = +widgetCounter.value // le + permet de transformer en nombre, value rends toujours un string
        const annonceImages = document.querySelector('#add_car_images')

        // recup le prototype des entrées data-prototype
        const prototype = annonceImages.dataset.prototype.replace(/__name__/g, index) // drapeau g pour indiquer que l'on va le faire plusieurs fois
         console.log(prototype)

        // injecter le code dans la div
        annonceImages.insertAdjacentHTML('beforeend', prototype)
        widgetCounter.value = index + 1

        handleDeleteButtons() // pour mettre à jour les tables delete et ajouter l'event
    })

    const updateCounter = () => {
        const count = document.querySelectorAll('#add_car div.form-group').length
        document.querySelector('#add_car_images').value = count
    }

    const handleDeleteButtons = () => {
        var deletes = document.querySelectorAll("button[data-action='delete']")

        deletes.forEach(button => {
            button.addEventListener('click', () => {
                const target = button.dataset.target
                const elementTarget = document.querySelector(target)
                if (elementTarget) {
                    elementTarget.remove() // supprimer l'élément
                }
            })
        })
    }

    updateCounter()
    handleDeleteButtons()