let radius = 100;
let starttime = 0;

let sColor, mColor, hColor = null;
let sFadeColor = null;
let sFadeFinished = true;

function setup() {
	let canvas = createCanvas(400, 400);
	canvas.parent(document.getElementById("timer"));
	radius = width;
	
	let d = new Date();
	starttime = d.getTime();
	starttime-=55000;
	
	sColor = color(255,0,0,255);
	sFadeColor = color(255,0,0,0);
	sFadeTarget = color(255,0,0,0);

	mColor = color(0,255,0,255);
	hColor = color(0,0,255,255);
	
	frameRate(60);
	strokeCap(SQUARE);
	smooth();
}

function draw() {
	translate(width/2, height/2);
	rotate(radians(-90));
	
	clear();

	noFill();
	strokeWeight(radius*0.1);
	
	let seconds = getSeconds();
	let minutes = floor(seconds/60);
	let hours = floor(minutes/60);

	
	if(seconds>=60 && seconds%60<5) {
		if(sFadeFinished && seconds%60<2.5) {
			sFadeFinished=false;
			sFadeColor = lerpColor(sColor,sColor,0.0);
		}

		var oldAlpha = alpha(sFadeColor);
		sFadeColor = lerpColor(sFadeColor, sFadeTarget, 0.05);
		
		if(alpha(sFadeColor)==oldAlpha) {
			sFadeColor.setAlpha(0);
		} else {
			stroke(sFadeColor);
			ellipse(0,0,radius*0.9);
		}
	} else {
		sFadeFinished=true;
		sFadeColor.setAlpha(0);
	}

	stroke(sColor);
	arc(0,0,radius*0.9,radius*0.9,0,radians(360/60*seconds));
	
	if(minutes>0) {
		stroke(mColor);
		arc(0,0,radius*0.7, radius*0.7, 0, radians(360/60*minutes));
	}
	
	if(hours>0) {
		stroke(hColor);
		arc(0,0,radius*0.5, radius*0.5, 0, radians(360/24*hours));
	}
}

function getSeconds() {
	let d = new Date();
	return (d.getTime()-starttime)/1000;
}