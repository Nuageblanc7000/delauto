// la classe attribué au paragraphe cible
const truncText = document.querySelectorAll('.truncText')
// la limite de la coupure que l'on veut
const subLine = 100
// je fais un truncate que si ma description du véhicule est plus grande que 100 caractères
const truncateText =(text) => {
    let traitementValue;
    text.forEach(value =>{
       traitementValue = value.innerHTML
        // les replaces non obligatoire si vous n'avez pas inséré de balise dans la base de donnée
        // sinon on les enlèves au début pour bien commencer la coupure.
        traitementValue.replace('<p>',' ')
        traitementValue.replace('</p>',' ')
        if(traitementValue.length > subLine){
            //on gère la coupure ici avec la function substring
            let trimmedString = traitementValue.substr(0, subLine)
// on vien aussi vérifier que le dernier caractère est du vide
            trimmedString = trimmedString.substr(0, Math.min(trimmedString.length, trimmedString.lastIndexOf(" ")))
        
            return value.innerHTML = `${trimmedString +"..."}`
        }
    })
}
console.log(truncText)
truncateText(truncText)