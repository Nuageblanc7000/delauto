
        const naviColor = document.querySelector('.naviColor');
        const vidBot = document.querySelector('.vidBot')

        const changeColor =()=>{

            let infoVid = vidBot.getBoundingClientRect().bottom
            
            const  {scrollTop} = document.documentElement 
            
            let infoNav = naviColor.getBoundingClientRect().top;
            let infoNavBottom = naviColor.getBoundingClientRect().bottom;
            console.log(infoVid)

            if(infoNav  >=  (infoVid).toFixed() || infoNavBottom  >=  (infoVid - 50).toFixed() ){
               
                naviColor.classList.add('headerDark')
    
            }else{
                naviColor.classList.remove('headerDark')
            }
        }
        
        window.addEventListener('scroll',changeColor)
    