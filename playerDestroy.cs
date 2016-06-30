using UnityEngine;
using System.Collections;

public class playerDestroy : MonoBehaviour {
	public int pointAdd = 100;
	public AudioClip[] audioClip;
	// Use this for initialization
	void Start () {
	
	}

	void OnCollisionEnter2D(Collision2D target){
		if (target.gameObject.name == "Player") {
			point.Addpoint (pointAdd);
			Destroy(gameObject);
		}
		if (target.gameObject.name == "seas" || target.gameObject.name == "monster") {
			Destroy(gameObject);
		}
}
	
	// Update is called once per frame
	void Update () {
	
	}
	void PlaySound(int clip){
		GetComponent<AudioSource>().clip = audioClip[clip];
		GetComponent<AudioSource>().Play ();
	}
}
