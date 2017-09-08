using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading;
using System.IO;

namespace MakeWords
{
    class Program
    {
        static void Main(string[] args)
        {

            Dictionary<string, string> dict = new Dictionary<string, string>();
            dict.Clear();
            for(int i=0;i<2000;i++)
            {
                string key = randomkeys(4);
                if (!dict.ContainsKey(key))
                { 
                    dict.Add(key,key);
                }
            }
            string buffer = "";
            foreach (KeyValuePair<string, string> item in dict)
            {
                buffer += item.Key + "\n";
                Console.Write(item.Key);
                Console.WriteLine();
            }


            string CurrentDirectory = System.IO.Directory.GetCurrentDirectory();
            StreamWriter sw = new StreamWriter(CurrentDirectory + "\\words.txt");
            sw.Write(buffer);
            sw.Flush();
            sw.Close();
        }

        public static string randomkeys(int length)
        {
            string pattern = "abcdefghijklmnopqrstuvwxyz";
            string key = "";
            Thread.Sleep(10);
            long tick = DateTime.Now.Ticks;
            Random ro = new Random((int)(tick & 0xffffffffL) | (int)(tick >> 32));
            for (int i = 0; i < length; i++)
            {
                key += pattern[ro.Next(0, pattern.Length)];
            }
            return key;
        }
    }
}
