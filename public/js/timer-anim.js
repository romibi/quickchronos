let radius = 100;
let starttime = 0;

let bgColor, inColor, sColor, mColor, hColor = null;

function setup() {
	let canvas = createCanvas(400, 400);
	canvas.parent(document.getElementById("timer"));
	radius = width;
	
	let d = new Date();
	starttime = d.getTime();
	
	bgColor = color(255, 255, 255, 10);
	inColor = color(255, 255, 255, 255);
	sColor = color(255,0,0,255);
	mColor = color(0,255,0,255);
	hColor = color(0,0,255,255);
	
	frameRate(60);
	noStroke();
	
}

function draw() {
	translate(width/2, height/2);
	rotate(radians(-90));
	
	fill(bgColor);
	ellipse(0,0,radius+2);
	
	let s = getSeconds();
	let m = floor(s/60);
	let h = floor(m/60);
	
	
	fill(sColor);
	arc(0,0,radius,radius,0,radians(360/60*s));
	
	fill(inColor);
	arc(0,0,radius*0.8, radius*0.8, 0, radians(360/60*(s+1)));
	
	if(m>0) {
		fill(mColor);
		arc(0,0,radius*0.8, radius*0.8, 0, radians(360/60*m));
		
		fill(inColor);
		arc(0,0,radius*0.6, radius*0.6, 0, radians(360/60*(m+1)));
	}
	
	if(h>0) {
		fill(hColor);
		arc(0,0,radius*0.6, radius*0.6, 0, radians(360/24*h));
		
		fill(inColor);
		arc(0,0,radius*0.4, radius*0.4, 0, radians(360/24*(h+1)));
	}
}

function getSeconds() {
	let d = new Date();
	return (d.getTime()-starttime)/1000;
}