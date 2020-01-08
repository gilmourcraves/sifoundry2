const connectionArray = ['0-1', '0-2', '1-2', '1-3', '1-6', '2-3', '2-4', '3-4', '4-5', '5-8', '5-13', '6-7', '7-8', '7-9', '8-9', '8-10', '8-11', '8-13', '9-10', '9-12', '10-11', '10-12', '11-12', '11-13', '12-13', '1-logo', '3-logo', '4-logo', '5-logo', '7-logo', '8-logo'];
const textDataArray = [
    {id: '0-3', offset: {x: -55, y: -0}},
    {id: '1-6', offset: {x: -55, y: -5}},
    {id: '2-10', offset: {x: 10, y: 5}},
    {id: '3-4', offset: {x: 5, y: -5}},
    {id: '4-1', offset: {x: -70, y: -8}}, /**/
    {id: '5-7', offset: {x: -70, y: -8}} /**/
];
const textContentArray = [
    {
        title: 'Startups',
        body: 'At no cost, we help you identify and build meaningful relationships with C-suite decision makers - at the right time and level - to unlock impactful customer, partnership, investment or exit opportunities.'
    },
    /* 	{title: 'Academics' , body:'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'}, */
    {
        title: 'Investors',
        body: 'We help you accelerate your portfolio companies’ digital transformations and global business development efforts. For firms, we bring an informational edge and unique lense to deal diligence and expand your network of F500 corporate decision makers, strategic investors and acquirers.'
    },
    {
        title: 'Corporates',
        body: 'We serve as trusted, embedded advisors and thought partners, providing unique insights, strategic deal flow and actionable connectivity to key players across the landscape.'
    }//,
    /* 	{title: 'Influencers' , body:'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'} */
]

// mobile display

var arrLen = textContentArray.length;
var str = '';
for (var i = 0; i < arrLen; i++) {
    str = str + '<li><a href="#">' + textContentArray[i].title + ' + </a>';
    str = str + '<div><p>' + textContentArray[i].body  + '</p></div></li>';
}

$('#container-connecting-mobile').html('<ul>' + str + '</ul>');

var innerWidth = window.innerWidth;

if(innerWidth > 992) {


gsap.registerPlugin(CustomEase, CustomWiggle);
const getLine = () => document.createElementNS(xmlns, 'line');
const addLine = el => connectionContainer.appendChild(el);
const select = s => document.querySelector(s);
const selectAll = s => document.querySelectorAll(s)
const xmlns = "http://www.w3.org/2000/svg";
const infoPanelSize = {width: 240, height: 170};

const connectionContainer = select('.connection-container');
const sfSVG = select('.sfSVG');
const logo = select('#cg-logo');
const panelContainer = select('.panel-container');
const calcRect = select('.calc-rect');
const panelText = select('.panel-text');
const allBoxes = gsap.utils.toArray(selectAll('.box'));
const boxSize = allBoxes[0].getAttribute('width');
const logoSize = logo.getBBox().width;
const boxSizeOffset = boxSize / 2;
const logoSizeOffset = logoSize / 2;
const numWiggles = 7;
const wiggleAmount = {x: 23, y: 8};
const dotWiggle = CustomWiggle.create("", {type: "easeInOut", wiggles: numWiggles});
const allBoxLabels = gsap.utils.toArray('.boxLabel');

const calculateOriginDistance = (el, pos) => {
    return Math.floor(
        Math.sqrt(
            Math.pow(pos.x - Number(el.getAttribute('data-init-x')), 2) +
            Math.pow(pos.y - Number(el.getAttribute('data-init-y')), 2)
        )
    );
}

let gradSetter = gsap.quickSetter('#grad', 'attr')
//gsap.quickSetter('#grad', 'cy')

const pt = sfSVG.createSVGPoint();

const TWO_PI = Math.PI * 2;
const DAMPENER = 0.073;
const SPRING = 0.21;
const MAX_BOX_RANGE = 140;
const MAX_LOGO_RANGE = 75;

let gradObj = {x: 400, y: 240}
let mousePos = {x: 0, y: 0};
let setBoxFloatRadius = (isSelected) => {
    return (isSelected) ? 0.07 : 0.5;
};
let boxFloatRadius = setBoxFloatRadius(false);
let cursorPoint = (e) => {
    pt.x = e.clientX;
    pt.y = e.clientY;
    return pt.matrixTransform(sfSVG.getScreenCTM().inverse());
}
let currentText = null;

gsap.set('svg', {
    visibility: 'visible'
});

gsap.set(logo, {
    x: 348,
    y: 252
});

let boxData = [];
let logoData = {};
let connObj = {};
let textObj = [];
let lineArray = [];
let pulse0Tl = gsap.timeline();
let pulse1Tl = gsap.timeline();
let pulse2Tl = gsap.timeline();
let build = () => {
    //build lines
    for (let i = 0; i < connectionArray.length; i++) {
        //let line = getLine();
        addLine(connObj['conn' + connectionArray[i].replace('-', '')] = getLine());
        //lineArray.push(l)
    }
    ;

    //build text
    for (let i = 0; i < textDataArray.length; i++) {
        textObj[i] = 'boxLabel' + textDataArray[i].id.split('-')[0];
    }
    ;
    //build box pos
    for (let i = 0; i < allBoxes.length; i++) {
        gsap.set(allBoxes[i], {
            x: allBoxes[i].getAttribute('x'),
            y: allBoxes[i].getAttribute('y')
        })

        allBoxes[i].setAttribute('data-init-x', allBoxes[i].getAttribute('x'));
        allBoxes[i].setAttribute('data-init-y', allBoxes[i].getAttribute('y'));
        boxData.push({
            box: allBoxes[i],
            vx: 0,
            vy: 0,
            destX: Number(allBoxes[i].getAttribute('x')),
            destY: Number(allBoxes[i].getAttribute('y')),
            initX: Number(allBoxes[i].getAttribute('x')),
            initY: Number(allBoxes[i].getAttribute('y'))
        })
    }

    logo.setAttribute('data-init-x', gsap.getProperty(logo, 'x'));
    logo.setAttribute('data-init-y', gsap.getProperty(logo, 'y'));

    logoData = {
        box: logo,
        vx: 0,
        vy: 0,
        destX: gsap.getProperty(logo, 'x'),
        destY: gsap.getProperty(logo, 'y'),
        initX: gsap.getProperty(logo, 'x'),
        initY: gsap.getProperty(logo, 'y')
    }
    gsap.set('.boxLabel', {
        transformOrigin: '50% 50%'
    })
    gsap.set(allBoxes, {
        transformOrigin: '50% 50%',
        attr: {
            x: 0,
            y: 0
        }
    })

    var boxCountX = -1;
    var boxCountY = -1;
    for (var i = 0, len = allBoxes.length; i < len; i++) {
        let tl = gsap.timeline()
        tl.to(allBoxes[i], {
            duration: 10,
            x: '+=' + TWO_PI,
            y: '+=' + TWO_PI,
            repeat: -1,
            modifiers: {
                x: function (x) {
                    let offsetX = 0;
                    if (boxCountX >= allBoxes.length - 1) {
                        boxCountX = 0;
                    } else {
                        boxCountX++;
                    }
                    offsetX = (Math.cos(parseFloat(x, 10)) * boxFloatRadius);
                    return (boxData[boxCountX].destX + offsetX ) + 'px'
                },
                y: function (y) {
                    let offsetY = 0;
                    if (boxCountY >= allBoxes.length - 1) {
                        boxCountY = 0;
                    } else {
                        boxCountY++;

                    }
                    offsetY = (Math.cos(parseFloat(y, 10)) * boxFloatRadius);
                    return (boxData[boxCountY].destY + offsetY) + 'px'
                }
            },
            ease: 'none'
        })
//do the logo
        if (i === allBoxes.length - 1) {
            gsap.to(logo, {
                duration: 'random(5, 10)',
                x: '+=' + TWO_PI,
                y: '+=' + TWO_PI,
                repeat: -1,
                modifiers: {
                    x: function (x) {
                        let offsetX = 0;
                        offsetX = (Math.cos(parseFloat(x, 10)) * boxFloatRadius);
                        return (logoData.destX + offsetX) + 'px'
                    },
                    y: function (y) {
                        let offsetY = 0;
                        offsetY = (Math.cos(parseFloat(y, 10)) * boxFloatRadius);
                        return (logoData.destY + offsetY) + 'px'
                    }
                },
                ease: 'none'
            })
        }
    }


    //pulses
    pulse0Tl.to('.pulse0 circle', {
        attr: {
            r: 10
        },
        duration: 3,
        opacity: 0,
        stagger: {
            each: 1,
            repeat: -1
        }
    })
    pulse1Tl.to('.pulse1 circle', {
        attr: {
            r: 10
        },
        duration: 3,
        opacity: 0,
        stagger: {
            each: 1,
            repeat: -1
        }
    })
    pulse2Tl.to('.pulse2 circle', {
        attr: {
            r: 10
        },
        duration: 3,
        opacity: 0,
        stagger: {
            each: 1,
            repeat: -1
        }
    })

    gsap.to('.pulse0', {
        x: '+=1',
        y: '+=1',
        repeat: -1,
        modifiers: {
            x: () => gsap.getProperty('#box3', 'x') + boxSizeOffset,
            y: () => gsap.getProperty('#box3', 'y') + boxSizeOffset
        },
        ease: 'none'
    })

    gsap.to('.pulse1', {
        x: '+=1',
        y: '+=1',
        repeat: -1,
        modifiers: {
            x: () => gsap.getProperty('#box6', 'x') + boxSizeOffset,
            y: () => gsap.getProperty('#box6', 'y') + boxSizeOffset
        },
        ease: 'none'
    })

    gsap.to('.pulse2', {
        x: '+=1',
        y: '+=1',
        repeat: -1,
        modifiers: {
            x: () => gsap.getProperty('#box10', 'x') + boxSizeOffset,
            y: () => gsap.getProperty('#box10', 'y') + boxSizeOffset
        },
        ease: 'none'
    })

}

const connect = () => {

    for (var i = 0, len = connectionArray.length; i < len; i++) {
        let isLogo = connectionArray[i].split('-')[1] == 'logo' ? true : false;
        gsap.set(connObj[Object.keys(connObj)[i]], {
            attr: {
                x1: gsap.getProperty('#box' + connectionArray[i].split('-')[0], 'x') + (boxSize / 2),
                y1: gsap.getProperty('#box' + connectionArray[i].split('-')[0], 'y') + (boxSize / 2),
                x2: isLogo ? (gsap.getProperty(logo, 'x') + logoSizeOffset) : gsap.getProperty(('#box' + connectionArray[i].split('-')[1]), 'x') + (boxSize / 2),
                y2: isLogo ? (gsap.getProperty(logo, 'y') + logoSizeOffset) : gsap.getProperty(('#box' + connectionArray[i].split('-')[1]), 'y') + (boxSize / 2),
            }
        })
    }


    for (var i = 0, len = textDataArray.length; i < len; i++) {
        gsap.set(`#${textObj[i]}`, {
            x: gsap.getProperty('#box' + textDataArray[i].id.split('-')[1], 'x') + textDataArray[i].offset.x,
            y: gsap.getProperty('#box' + textDataArray[i].id.split('-')[1], 'y') + textDataArray[i].offset.y,
        })
    }

    for (var i = 0, len = allBoxes.length; i < len; i++) {
        let boxDistance = calculateOriginDistance(allBoxes[i], mousePos);
        if (boxDistance < MAX_BOX_RANGE) {
            boxData[i].vx += (mousePos.x - gsap.getProperty(allBoxes[i], 'x')) * DAMPENER;
            boxData[i].vx *= SPRING;
            boxData[i].destX = gsap.getProperty(allBoxes[i], 'x') + boxData[i].vx;

            boxData[i].vy += (mousePos.y - gsap.getProperty(allBoxes[i], 'y')) * DAMPENER;
            boxData[i].vy *= SPRING;
            boxData[i].destY = gsap.getProperty(allBoxes[i], 'y') + boxData[i].vy;

        } else {

            boxData[i].vx += (boxData[i].initX - gsap.getProperty(allBoxes[i], 'x')) * DAMPENER;
            boxData[i].vx *= SPRING;
            boxData[i].destX = gsap.getProperty(allBoxes[i], 'x') + boxData[i].vx;

            boxData[i].vy += (boxData[i].initY - gsap.getProperty(allBoxes[i], 'y')) * DAMPENER;
            boxData[i].vy *= SPRING;
            boxData[i].destY = gsap.getProperty(allBoxes[i], 'y') + boxData[i].vy;
        }
    }

    if (calculateOriginDistance(logo, mousePos) < MAX_LOGO_RANGE) {

        logoData.vx += (mousePos.x - (gsap.getProperty(logo, 'x') + logoSizeOffset)) * DAMPENER;
        logoData.vx *= SPRING;
        logoData.destX = gsap.getProperty(logo, 'x') + logoData.vx;

        logoData.vy += (mousePos.y - (gsap.getProperty(logo, 'y') + logoSizeOffset)) * DAMPENER;
        logoData.vy *= SPRING;
        logoData.destY = gsap.getProperty(logo, 'y') + logoData.vy;

    } else {

        logoData.vx += (logoData.initX - gsap.getProperty(logo, 'x')) * DAMPENER;
        logoData.vx *= SPRING;
        logoData.destX = gsap.getProperty(logo, 'x') + logoData.vx;

        logoData.vy += (logoData.initY - gsap.getProperty(logo, 'y')) * DAMPENER;
        logoData.vy *= SPRING;
        logoData.destY = gsap.getProperty(logo, 'y') + logoData.vy;

    }

    gradSetter({cx: mousePos.x})
    gradSetter({cy: mousePos.y})

}//end connect

build();

document.onmousemove = e => mousePos = cursorPoint(e)
gsap.ticker.add(connect);

sfSVG.addEventListener('mouseover', e => {

    let id = (e.target.getAttribute('data-id'));

    if (id == null) {
        gsap.set(panelContainer, {
            autoAlpha: 0
        })
        gsap.to('.pulse', {
            autoAlpha: 1,
            ease: 'power2'
        })

        boxFloatRadius = setBoxFloatRadius(false);
        currentText = null;
        return;
    }

    else {

        boxFloatRadius = setBoxFloatRadius(true);

        gsap.set(panelContainer, {
            autoAlpha: 1
        })
        gsap.fromTo('.info-panel', {
            opacity: 0,
            scale: 0.6
        }, {
            duration: 0.41,
            scale: 1,
            opacity: 1,
            ease: 'elastic(0.3, 0.38)'
        })

        gsap.to(`.pulse${id}`, {
            autoAlpha: 0,
            ease: 'power2'
        })

    }


    currentText = select('#boxLabel' + id);

    let panelDest = {
        x: currentText.getBoundingClientRect().x,
        y: currentText.getBoundingClientRect().y
    }
    gsap.set(panelContainer, {
        left: ((panelDest.x + panelText.getBoundingClientRect().width) > (calcRect.getBoundingClientRect().x + calcRect.getBoundingClientRect().width)) ? (calcRect.getBoundingClientRect().x + calcRect.getBoundingClientRect().width) - panelText.getBoundingClientRect().width : panelDest.x,
        top: (panelDest.y - panelText.getBoundingClientRect().height < 0) ? panelText.getBoundingClientRect().height / 2 : panelDest.y
    })

    document.querySelector('.info-panel h1').innerHTML = textContentArray[id].title;
    document.querySelector('.info-panel p').innerHTML = textContentArray[id].body;

})

}
