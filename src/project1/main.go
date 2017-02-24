package main

import (
	"project1/router"
	"github.com/kataras/iris"
)

func main(){

	router.Init()
	iris.Listen(":9091")

}