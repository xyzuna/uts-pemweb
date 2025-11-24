import express from "express";
import cors from "cors";
import dotenv from "dotenv";
import OpenAI from "openai";
import fs from "fs";

dotenv.config();

const app = express();
app.use(cors());
app.use(express.json({ limit: "10mb" }));

// OPENAI
const client = new OpenAI({
  apiKey: process.env.OPENAI_API_KEY
});

// ----------- API: AI TUTOR -------------
app.post("/api/ai-tutor", async (req, res) => {
  try {
    const { text, mode } = req.body;

    const systemPrompt =
      mode === "id"
        ? "Kamu adalah tutor Bahasa Jepang untuk penutur Indonesia. Jelaskan dengan bahasa Indonesia secara sederhana. Jika user berbicara dalam bahasa Jepang, jelaskan maknanya."
        : "You are a friendly Japanese tutor. Speak in simple Japanese (N5–N4 level).";

    const ai = await client.chat.completions.create({
      model: "gpt-4o-mini",
      messages: [
        { role: "system", content: systemPrompt },
        { role: "user", content: text }
      ]
    });

    const reply = ai.choices[0].message.content;
    return res.json({ reply });
  } catch (err) {
    console.error("AI ERROR:", err);
    return res.json({ reply: "すみません、今サーバーが混んでいます。" });
  }
});

// ----------- API: TTS (Text to Speech) -------------
app.post("/api/tts", async (req, res) => {
  try {
    const { text } = req.body;

    const speech = await client.audio.speech.create({
      model: "gpt-4o-mini-tts",
      voice: "sakura", // boleh: nova, alloy, verse
      input: text
    });

    // hasil audio (buffer)
    const audioBuffer = Buffer.from(await speech.arrayBuffer());

    res.set({
      "Content-Type": "audio/mpeg",
      "Content-Length": audioBuffer.length
    });

    return res.send(audioBuffer);

  } catch (err) {
    console.error("TTS ERROR:", err);
    return res.status(500).json({ error: "TTS error" });
  }
});

// ---------------------------------------
app.listen(process.env.PORT, () => {
  console.log("Sakura AI Tutor Backend berjalan di port", process.env.PORT);
});
