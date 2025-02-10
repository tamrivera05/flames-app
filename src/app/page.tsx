"use client"

import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card"
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@radix-ui/react-label";
import { Heart } from "lucide-react";
import React, { useState } from "react";
import clsx from "clsx";


export default function Home() {

  const [result, setResult] = useState<string | string[]>("");

  const handleSubmit = async (event: React.FormEvent<HTMLFormElement>) => {
    event.preventDefault();

    const form = event.currentTarget;
    const formData = new FormData(event.currentTarget);
    const data = Object.fromEntries(formData.entries());

    try {
      const response = await fetch("http://localhost:8080/form-handler.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: new URLSearchParams(data as Record<string, string>),
      });

      const json = await response.json();
      if (typeof json === "object" && json !== null) {
        setResult([
          `${json.fullName1} and ${json.fullName2} are`,
          `${json.flamesResult} and ${json.zodiacCompatibility}`,
          `${json.birthdate1} - ${json.zodiacSign1} - ${json.symbol1}`,
          `${json.birthdate2} - ${json.zodiacSign2} - ${json.symbol2}`,
        ]);
      } else {
        setResult(["Invalid response received."]);
      }
      form.reset(); //resets form after results are shown
    } catch (error) {
      console.error("Error submitting the form:", error);
      setResult(["An error occurred while calculating compatibility."]);
    }
  };


  return (
    <div className="min-h-screen bg-gradient-to-br from-pink-100 to-pink-500 flex flex-col items-center justify-center p-4">
      <Card className="w-full max-w-xl shadow-lg">
        <div className="bg-gradient-to-r from-red-400 to-pink-500 rounded-t-xl">
          <CardHeader>
            <CardTitle className="text-4xl font-extrabold text-center text-white">Love Calculator</CardTitle>
            <CardDescription className="text-center text-white">Discover you and your lover's compatibility!</CardDescription>
          </CardHeader>
        </div>
          <form className="gap-6" action="http://localhost:8080/form-handler.php" method="post" onSubmit={handleSubmit}>
          <CardContent className="p-6 grid grid-cols-2 gap-6">
            <div className="gap-2 flex flex-col">
                <Label htmlFor="Your Name" className="text-sm font-medium text-gray-700">Your First Name:</Label>
                <Input placeholder="Enter your name" className="w-full px-4 py-2 rounded-md border-pink-300 focus:border-pink-500 focus:ring focus:ring-pink-200" type="text" id="firstName1" name="firstName1"/>
                <Label htmlFor="Your Name" className="text-sm font-medium text-gray-700">Your Last Name:</Label>
                <Input placeholder="Enter your name" className="w-full px-4 py-2 rounded-md border-pink-300 focus:border-pink-500 focus:ring focus:ring-pink-200" type="text" id="lastName1" name="lastName1"/>
                <Label htmlFor="Your Birthdate" className="text-sm font-medium text-gray-700">Your Birthdate:</Label>
                <Input placeholder="Enter your birthdate" className="w-full px-4 py-2 rounded-md border-pink-300 focus:border-pink-500 focus:ring focus:ring-pink-200" type="text" id="birthdate1" name="birthdate1"/>
            </div>
            <div className="gap-2 flex flex-col">
              <Label htmlFor="Your Lover's Name" className="text-sm font-medium text-gray-700">Your Lover's First Name:</Label>
              <Input placeholder="Enter your lover's name" className="w-full px-4 py-2 rounded-md border-pink-300 focus:border-pink-500 focus:ring focus:ring-pink-200" type="text" id="firstName2" name="firstName2"/>
              <Label htmlFor="Your Lover's Name" className="text-sm font-medium text-gray-700">Your Lover's Last Name:</Label>
              <Input placeholder="Enter your lover's name" className="w-full px-4 py-2 rounded-md border-pink-300 focus:border-pink-500 focus:ring focus:ring-pink-200" type="text" id="lastName2" name="lastName2"/>
              <Label htmlFor="Your Lover's Birthdate" className="text-sm font-medium text-gray-700">Your Lover's Birthdate:</Label>
              <Input placeholder="Enter your lover's birthdate" className="w-full px-4 py-2 rounded-md border-pink-300 focus:border-pink-500 focus:ring focus:ring-pink-200" type="text" id="birthdate2" name="birthdate2"/>
            </div>
          </CardContent>
            <CardFooter> 
              <Button className="w-full bg-gradient-to-r from-red-400 to-pink-500 hover:from-red-500 hover:to-pink-600 text-white font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out transform hover:scale-105" type="submit"><span className="flex flex-row items-center justify-center gap-2"> <Heart/> Calculate Compatibility </span></Button>
            </CardFooter>
          </form>
        {result && (
          <div className="p-6 bg-gradient-to-r from-purple-100 to-pink-100 flex flex-col gap-2 rounded-b-lg">
            <h2 className="text-2xl font-bold text-center mb-1 text-purple-800">Your Result:</h2>
            {Array.isArray(result) ? (
              result.map((item: string, index: number) => (
                  <p key={index} className={clsx("text-md font-bold text-center", index === 0 && "text-pink-400", index === 1 && "text-3xl text-pink-600 font-extrabold", index >= 2 && index <= 6 && "text-pink-400" )}>{item}</p>
              ))
              ) : (
                <p className="text-md font-extrabold text-center text-pink-600">{result}</p>
              )}
          </div>
        )}    
      </Card>
      <Card className="w-full max-w-xl shadow-lg mt-5 bg-gradient-to-r from-red-400 to-pink-500">
          <div className="m-4 text-sm flex flex-col justify-center items-center">
                <p className="font-extrabold text-center mb-2 text-2xl text-white">F.L.A.M.E.S. meaning:</p>
                <ul className="gap-4 grid grid-cols-2 space-x-8 text-white">
                  <div>
                    <li className="flex items-center"><Heart size={16} className="text-white mr-1" /> F - Friends</li>
                    <li className="flex items-center"><Heart size={16} className="text-white mr-1" /> L - Lovers</li>
                    <li className="flex items-center"><Heart size={16} className="text-white mr-1" /> A - Anger</li>
                  </div>
                  <div>
                    <li className="flex items-center"><Heart size={16} className="text-white mr-1" /> M - Marriage</li>
                    <li className="flex items-center"><Heart size={16} className="text-white mr-1" /> E - Engaged</li>
                    <li className="flex items-center"><Heart size={16} className="text-white mr-1" /> S - Soulmates</li>
                  </div>
                </ul>
              </div>
      </Card>
    </div>
  );
}
