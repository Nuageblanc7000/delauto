const addImage = document.querySelector('#add-image')

addImage.addEventListener('click',(e)=>{
    e.preventDefault()
    // compter combien j'ai de form-group pour les indices ex: annonce_image_0_url
    const widgetCounter = document.querySelector("#widgets-counter")
    const index = +widgetCounter.value // le + permet de transofmer en nombre, value rends tjrs un string 
    const annonceImages = document.querySelector('#add_car_images')
console.log(annonceImages)
    //recup le prototype des entrées data-prototype
    const prototype = annonceImages.dataset.prototype.replace(/__name__/g, index) // drapeau g pour indiquer que l'on va le faire plusieurs fois 

    //injecter le code dans la div
    annonceImages.insertAdjacentHTML('beforeend', prototype)
    widgetCounter.value = index+1

    handleDeleteButtons() // pour mettre à jour le tableau deletes et ajouter l'évent 
})

const updateCounter = () => {
    const count = document.querySelectorAll('#add_car_images div.form-group').length
    document.querySelector('#widgets-counter').value = count
    console.log(count)
}

const handleDeleteButtons = () => {
    var deletes = document.querySelectorAll("button[data-action='delete']")
    deletes.forEach(button => {
        button.addEventListener('click',()=>{
            const target = button.dataset.target
            const elementTarget = document.querySelector(target)
            console.log(target)
            if(elementTarget){
                console.log(elementTarget)
                elementTarget.remove() // supprimer l'élément 
            }
        })
    })


}

updateCounter()
handleDeleteButtons()